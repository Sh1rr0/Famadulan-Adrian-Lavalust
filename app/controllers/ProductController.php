<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->model('ProductModel');
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // READ
    public function index()
    {
        $data['products'] = $this->ProductModel->all();
        $data['username'] = $_SESSION['username'] ?? 'User';
        $this->call->view('products_view', $data);
    }

    // CREATE - show form
    public function create()
    {
        $this->call->view('product_create_view');
    }

    // CREATE - store
    public function store()
    {
        $this->ProductModel->insert([
            'product_name' => $_POST['product_name'],
            'description'  => $_POST['description'],
            'price'        => $_POST['price'],
            'quantity'     => $_POST['quantity'],
        ]);
        header('Location: /products');
        exit;
    }

    // UPDATE - show form
    public function edit($id)
    {
        $data['product'] = $this->ProductModel->find($id);
        $this->call->view('product_edit_view', $data);
    }

    // UPDATE - handle submit
    public function update($id)
    {
        $this->db->query(
            "UPDATE products SET product_name = ?, description = ?, price = ?, quantity = ? WHERE id = ?",
            [
                $_POST['product_name'],
                $_POST['description'],
                $_POST['price'],
                $_POST['quantity'],
                $id
            ]
        );
        header('Location: /products');
        exit;
    }

    // DELETE
    public function delete($id)
    {
        $this->db->query("DELETE FROM products WHERE id = ?", [$id]);
        header('Location: /products');
        exit;
    }
}