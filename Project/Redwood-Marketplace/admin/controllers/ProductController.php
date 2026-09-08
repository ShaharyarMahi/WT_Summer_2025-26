<?php
require_once __DIR__ . '/../models/Product.php';

class ProductController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function index()
    {
        $products = $this->productModel->getAll();

        $message = $_SESSION['product_message'] ?? null;
        unset($_SESSION['product_message']);

        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/products/index.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    public function toggleStatus()
    {
        $id = $_GET['toggle'] ?? null;

        if ($id) {
            $this->productModel->toggleStatus($id);
            $_SESSION['product_message'] = 'Product status updated.';
        }

        header('Location: index.php?page=products');
        exit;
    }

    public function remove()
    {
        $id = $_GET['delete'] ?? null;

        if ($id) {
            $this->productModel->delete($id);
            $_SESSION['product_message'] = 'Product deleted.';
        }

        header('Location: index.php?page=products');
        exit;
    }
}