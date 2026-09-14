<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Prevent unauthenticated users from accessing products
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('Location: /login');
            exit;
        }

        $this->call->model('ProductModel');
    }

    public function index()
    {
        $data['products'] = $this->ProductModel->all();
        $data['username'] = $_SESSION['username'] ?? 'User';

        $this->call->view('products_view', $data);
    }

    public function create()
    {
        $this->call->view('product_create_view');
    }

    public function store()
    {
        $this->ProductModel->insert([
            'product_name' => $_POST['product_name'] ?? '',
            'description'  => $_POST['description'] ?? '',
            'price'        => $_POST['price'] ?? 0,
            'quantity'     => $_POST['quantity'] ?? 0
        ]);

        header('Location: /products');
        exit;
    }

    public function edit($id)
    {
        $product = $this->ProductModel->find($id);

        if (!$product) {
            header('Location: /products');
            exit;
        }

        $data['product'] = $product;
        $this->call->view('product_edit_view', $data);
    }

    public function update($id)
    {
        $this->ProductModel->update($id, [
            'product_name' => $_POST['product_name'] ?? '',
            'description'  => $_POST['description'] ?? '',
            'price'        => $_POST['price'] ?? 0,
            'quantity'     => $_POST['quantity'] ?? 0
        ]);

        header('Location: /products');
        exit;
    }

    public function delete($id)
    {
        $this->ProductModel->delete($id);

        header('Location: /products');
        exit;
    }
}