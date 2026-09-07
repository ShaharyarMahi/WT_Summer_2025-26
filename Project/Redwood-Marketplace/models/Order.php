<?php

class Order
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    public function getOrdersByUser($userId)
    {
        $sql = "SELECT
                    order_id,
                    order_number,
                    subtotal,
                    shipping_fee,
                    discount,
                    total_amount,
                    order_status,
                    created_at
                FROM orders
                WHERE user_id = ?
                ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "i",
            $userId
        );

        $stmt->execute();

        return $stmt->get_result();
    }


    

    public function getOrderById(
        $orderId,
        $userId
    ) {
        $sql = "SELECT
                    order_id,
                    user_id,
                    shipping_address_id,
                    order_number,
                    subtotal,
                    shipping_fee,
                    discount,
                    total_amount,
                    order_status,
                    created_at,
                    updated_at
                FROM orders
                WHERE order_id = ?
                AND user_id = ?
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "ii",
            $orderId,
            $userId
        );

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            return $result->fetch_assoc();
        }

        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | Get order items
    |--------------------------------------------------------------------------
    */

    public function getOrderItems($orderId)
    {
        $sql = "SELECT
                    oi.order_item_id,
                    oi.order_id,
                    oi.product_id,
                    oi.store_id,
                    oi.product_name,
                    oi.unit_price,
                    oi.quantity,
                    oi.subtotal,
                    oi.item_status
                FROM order_items oi
                WHERE oi.order_id = ?
                ORDER BY oi.order_item_id ASC";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "i",
            $orderId
        );

        $stmt->execute();

        return $stmt->get_result();
    }


    /*
    |--------------------------------------------------------------------------
    | Get shipping address
    |--------------------------------------------------------------------------
    */

    public function getShippingAddress(
        $addressId,
        $userId
    ) {
        $sql = "SELECT
                    address_id,
                    address_type,
                    full_name,
                    phone,
                    address_line,
                    city,
                    postal_code,
                    country
                FROM addresses
                WHERE address_id = ?
                AND user_id = ?
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "ii",
            $addressId,
            $userId
        );

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            return $result->fetch_assoc();
        }

        return false;
    }
}

?>