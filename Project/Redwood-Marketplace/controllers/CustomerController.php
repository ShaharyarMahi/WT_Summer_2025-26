<?php

require_once "config/auth.php";

class CustomerController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    public function index()
    {
        requireRole("customer");

        $userId = $_SESSION["user_id"];




        $sql = "SELECT COUNT(*) AS total_orders
                FROM orders
                WHERE user_id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $userId);

        $stmt->execute();

        $result = $stmt->get_result();

        $totalOrders = $result->fetch_assoc()["total_orders"];



        $sql = "SELECT COUNT(*) AS pending_orders
                FROM orders
                WHERE user_id = ?
                AND order_status = 'pending'";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $userId);

        $stmt->execute();

        $result = $stmt->get_result();

        $pendingOrders = $result->fetch_assoc()["pending_orders"];



        $sql = "SELECT COUNT(*) AS delivered_orders
                FROM orders
                WHERE user_id = ?
                AND order_status = 'delivered'";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $userId);

        $stmt->execute();

        $result = $stmt->get_result();

        $deliveredOrders = $result->fetch_assoc()["delivered_orders"];




        $sql = "SELECT COUNT(*) AS wishlist_items
                FROM wishlist_items wi
                INNER JOIN wishlists w
                    ON wi.wishlist_id = w.wishlist_id
                WHERE w.user_id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $userId);

        $stmt->execute();

        $result = $stmt->get_result();

        $wishlistItems = $result->fetch_assoc()["wishlist_items"];



        require "views/customer/dashboard.php";
    }

}
// Validate user login credentials

?>