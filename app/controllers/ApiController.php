<?php
class ApiController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->api = $this->call->library('api');
    }

    public function login()
    {
        $this->api->require_method('POST');
        $this->api->rate_limit();
        $input    = $this->api->body();
        $username = is_string($input['username'] ?? null) ? $input['username'] : '';
        $password = is_string($input['password'] ?? null) ? $input['password'] : '';

        $stmt = $this->db->raw(
            'SELECT id, username, password FROM auth_users WHERE username = ? LIMIT 1',
            [$username]
        );
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $this->verify_password($password, $user['password'])) {
            if (password_get_info($user['password'])['algoName'] === 'unknown') {
                $this->db->raw(
                    'UPDATE auth_users SET password = ? WHERE id = ?',
                    [password_hash($password, PASSWORD_DEFAULT), $user['id']]
                );
            }

            $tokens = $this->api->issue_tokens([
                'id'   => $user['id'],
                'role' => $user['username'] === 'admin' ? 'admin' : 'user',
            ]);
            $this->api->respond($tokens);
        } else {
            $this->api->respond_error('Invalid credentials', 401);
        }
    }

    public function logout()
    {
        $this->api->require_method('POST');
        $input = $this->api->body();
        $refresh_token = is_string($input['refresh_token'] ?? null) ? $input['refresh_token'] : '';
        if ($refresh_token !== '') {
            $this->api->revoke_refresh_token($refresh_token);
        }
        $this->api->respond(['message' => 'Logged out']);
    }

    public function options()
    {
        $this->api->respond(null, 204);
    }

    public function products()
    {
        $this->api->require_method('GET');
        $this->api->rate_limit();
        $auth = $this->api->require_jwt();
        $this->require_scope($auth, 'read');

        $products = $this->db->raw(
            'SELECT id, product_name, description, price, quantity
             FROM products ORDER BY id DESC'
        )->fetchAll(PDO::FETCH_ASSOC);

        $this->api->respond($products);
    }

    public function createProduct()
    {
        $this->api->require_method('POST');
        $this->api->rate_limit();
        $auth = $this->api->require_jwt();
        $this->require_scope($auth, 'write');

        $input = $this->api->body();
        $product = $this->validated_product($input);
        if (isset($product['error'])) {
            $this->api->respond_error($product['error'], 422);
        }

        $this->db->raw(
            'INSERT INTO products (product_name, description, price, quantity)
             VALUES (?, ?, ?, ?)',
            [$product['product_name'], $product['description'], $product['price'], $product['quantity']]
        );

        $product_id = $this->db->last_id();
        $created = $this->db->raw(
            'SELECT id, product_name, description, price, quantity
             FROM products WHERE id = ?',
            [$product_id]
        )->fetch(PDO::FETCH_ASSOC);

        $this->api->respond(['data' => $created], 201);
    }

    public function updateProduct($id)
    {
        $this->api->require_method('PUT');
        $this->api->rate_limit();
        $auth = $this->api->require_jwt();
        $this->require_scope($auth, 'write');
        $product_id = $this->validated_id($id);
        if ($product_id === null) {
            $this->api->respond_error('Invalid product id', 422);
        }

        $input = $this->api->body();
        $product = $this->validated_product($input);
        if (isset($product['error'])) {
            $this->api->respond_error($product['error'], 422);
        }

        $updated_count = $this->db->raw(
            'UPDATE products
             SET product_name = ?, description = ?, price = ?, quantity = ?
             WHERE id = ?',
            [$product['product_name'], $product['description'], $product['price'], $product['quantity'], $product_id]
        );

        if ($updated_count === 0) {
            $exists = $this->db->raw('SELECT id FROM products WHERE id = ? LIMIT 1', [$product_id])
                               ->fetch(PDO::FETCH_ASSOC);
            if (!$exists) {
                $this->api->respond_error('Product not found', 404);
            }
        }

        $updated = $this->db->raw(
            'SELECT id, product_name, description, price, quantity
             FROM products WHERE id = ?',
            [$product_id]
        )->fetch(PDO::FETCH_ASSOC);

        $this->api->respond(['data' => $updated]);
    }

    public function deleteProduct($id)
    {
        $this->api->require_method('DELETE');
        $this->api->rate_limit();
        $auth = $this->api->require_jwt();
        $this->require_scope($auth, 'delete');
        $product_id = $this->validated_id($id);
        if ($product_id === null) {
            $this->api->respond_error('Invalid product id', 422);
        }

        $deleted_count = $this->db->raw('DELETE FROM products WHERE id = ?', [$product_id]);
        if ($deleted_count === 0) {
            $this->api->respond_error('Product not found', 404);
        }

        $this->api->respond(['message' => 'Product deleted']);
    }

    public function list()
    {
        // Apply rate limiting before processing
        $this->api->rate_limit();

        $users = $this->db->table('users')
                          ->select('id, username, email, role, created_at')
                          ->get_all();
        $this->api->respond($users);
    }

    public function create()
    {
        $this->api->require_method('POST');
        $input = $this->api->body();

        $this->db->raw(
            "INSERT INTO users (username, email, password, role, created_at)
             VALUES (?, ?, ?, ?, NOW())",
            [
                $input['username'],
                $input['email'],
                password_hash($input['password'], PASSWORD_BCRYPT),
                $input['role'] ?? 'user',
            ]
        );

        $this->api->respond(['message' => 'User created'], 201);
    }

    public function update($id)
    {
        $this->api->require_method('PUT');
        $input = $this->api->body();

        $this->db->raw(
            "UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?",
            [$input['username'], $input['email'], $input['role'], $id]
        );

        $this->api->respond(['message' => 'User updated']);
    }

    public function delete($id)
    {
        $this->api->require_method('DELETE');
        $this->db->raw("DELETE FROM users WHERE id = ?", [$id]);
        $this->api->respond(['message' => 'User deleted']);
    }

    public function profile()
    {
        $auth = $this->api->require_jwt();
        $this->require_scope($auth, 'read');

        $stmt = $this->db->raw(
            "SELECT id, username FROM auth_users WHERE id = ?",
            [$auth['sub']]
        );
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $user['role'] = $user['username'] === 'admin' ? 'admin' : 'user';
        }

        $this->api->respond($user ?: ['message' => 'User not found']);
    }

    public function refresh()
    {
        $this->api->require_method('POST');
        $input = $this->api->body();
        $refresh_token = is_string($input['refresh_token'] ?? null) ? $input['refresh_token'] : '';
        $this->api->refresh_access_token($refresh_token);
    }

    private function require_scope(array $auth, string $scope): void
    {
        if (!in_array($scope, $auth['scopes'] ?? [], true)) {
            $this->api->respond_error('Forbidden', 403);
        }
    }

    private function verify_password(string $password, string $stored_password): bool
    {
        if (password_verify($password, $stored_password)) {
            return true;
        }

        return password_get_info($stored_password)['algoName'] === 'unknown'
            && hash_equals($stored_password, $password);
    }

    private function validated_id($id): ?int
    {
        if (!is_string($id) && !is_int($id)) {
            return null;
        }

        $validated = filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        return $validated === false ? null : $validated;
    }

    private function validated_product(array $input): array
    {
        $name = $input['product_name'] ?? null;
        $description = $input['description'] ?? '';
        $price = $input['price'] ?? null;
        $quantity = $input['quantity'] ?? null;

        if (!is_string($name) || trim($name) === '') {
            return ['error' => 'product_name is required'];
        }
        if (!is_string($description)) {
            return ['error' => 'description must be a string'];
        }
        if (!is_numeric($price) || (float) $price < 0 || (float) $price > 99999999.99) {
            return ['error' => 'price must be between 0 and 99999999.99'];
        }
        if (filter_var($quantity, FILTER_VALIDATE_INT) === false || (int) $quantity < 0) {
            return ['error' => 'quantity must be a non-negative integer'];
        }

        return [
            'product_name' => trim($name),
            'description' => $description,
            'price' => (float) $price,
            'quantity' => (int) $quantity,
        ];
    }
}