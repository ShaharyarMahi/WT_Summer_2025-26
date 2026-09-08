<?php
require_once __DIR__ . '/../models/SellerStore.php';

class SellerStoreController
{
    private $sellerStoreModel;

    public function __construct()
    {
        $this->sellerStoreModel = new SellerStore();
    }

    public function index()
    {
        $stores = $this->sellerStoreModel->getAll();

        $message = $_SESSION['seller_message'] ?? null;
        unset($_SESSION['seller_message']);

        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/sellers/index.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    public function approve()
    {
        $id = $_GET['approve'] ?? null;
        if ($id) {
            $this->sellerStoreModel->updateStatus($id, 'active');
            $_SESSION['seller_message'] = 'Store approved.';
        }
        header('Location: index.php?page=sellers');
        exit;
    }

    public function suspend()
    {
        $id = $_GET['suspend'] ?? null;
        if ($id) {
            $this->sellerStoreModel->updateStatus($id, 'suspended');
            $_SESSION['seller_message'] = 'Store suspended.';
        }
        header('Location: index.php?page=sellers');
        exit;
    }
}