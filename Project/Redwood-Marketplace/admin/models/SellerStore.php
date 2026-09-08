<?php
require_once __DIR__ . '/../config/database.php';

class SellerStore
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    /**
     * সব store, সাথে seller এর নাম/ইমেইল (users টেবিল থেকে) জয়েন করে
     */
    public function getAll()
    {
        $sql = "SELECT s.*, 
                       u.first_name, 
                       u.last_name, 
                       u.email
                FROM seller_stores s
                LEFT JOIN users u ON s.seller_id = u.user_id
                ORDER BY s.store_id DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM seller_stores WHERE store_id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function updateStatus($id, $status)
    {
        $stmt = $this->pdo->prepare("UPDATE seller_stores SET store_status = :status WHERE store_id = :id");
        return $stmt->execute(['status' => $status, 'id' => $id]);
    }
}