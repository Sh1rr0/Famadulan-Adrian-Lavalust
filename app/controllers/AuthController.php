<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->call->model('AuthModel');

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login()
    {
        $this->call->view('login_view');
    }

   public function authenticate()
{
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = $this->AuthModel->findByUsername($username);

    if ($user && $this->verify_password($password, $user['password'])) {
        if (password_get_info($user['password'])['algoName'] === 'unknown') {
            $this->db->raw(
                'UPDATE auth_users SET password = ? WHERE id = ?',
                [password_hash($password, PASSWORD_DEFAULT), $user['id']]
            );
        }

        session_regenerate_id(true);

        $_SESSION['logged_in'] = true;
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['username']  = $user['username'];

        header('Location: /products');
        exit;
    }

    header('Location: /login?error=1');
    exit;
}

    private function verify_password(string $password, string $stored_password): bool
    {
        if (password_verify($password, $stored_password)) {
            return true;
        }

        return password_get_info($stored_password)['algoName'] === 'unknown'
            && hash_equals($stored_password, $password);
    }

    public function logout()
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();

        header('Location: /login');
        exit;
    }
}