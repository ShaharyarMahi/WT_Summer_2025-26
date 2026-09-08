<?php
require_once __DIR__ . '/../config/database.php';

class Product
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    /**
     * সব প্রোডাক্ট - category name, store name, এবং inventory.quantity
     * (stock এর জন্য source of truth) একসাথে জয়েন করে আনা হচ্ছে
     */
    public function getAll()
    {
        $sql = "SELECT p.*, 
                       c.category_name, 
                       s.store_name, 
                       i.quantity AS stock_quantity
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.category_id
                LEFT JOIN seller_stores s ON p.store_id = s.store_id
                LEFT JOIN inventory i ON p.product_id = i.product_id
                ORDER BY p.product_id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE product_id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * active <-> inactive টগল করা হয়
     * (draft/out_of_stock থাকলে সরাসরি active করে দেওয়া হবে)
     */
    public function toggleStatus($id)
    {
        $product = $this->findById($id);
        if (!$product) return false;

        $newStatus = ($product['status'] === 'active') ? 'inactive' : 'active';

        $stmt = $this->pdo->prepare("UPDATE products SET status = :status WHERE product_id = :id");
        return $stmt->execute(['status' => $newStatus, 'id' => $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE product_id = :id");
        return $stmt->execute(['id' => $id]);
    }
}