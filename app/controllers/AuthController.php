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

    if ($user && $password === $user['password']) {

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