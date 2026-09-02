<?php

require_once "models/Order.php";
require_once "config/auth.php";

class OrderController
{
    private $orderModel;

    public function __construct($conn)
    {
        $this->orderModel =
            new Order($conn);
    }


    /*
    |--------------------------------------------------------------------------
    | My Orders
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        requireLogin();

        $userId =
            (int)$_SESSION["user_id"];


        $orders =
            $this->orderModel
                ->getOrdersByUser(
                    $userId
                );


        require "views/customer/orders.php";
    }


    /*
    |--------------------------------------------------------------------------
    | Order Details
    |--------------------------------------------------------------------------
    */

    public function details()
    {
        requireLogin();

        $userId =
            (int)$_SESSION["user_id"];


        $orderId =
            (int)($_GET["id"] ?? 0);


        if ($orderId <= 0) {

            header(
                "Location: index.php?page=orders"
            );

            exit;
        }


        /*
        ------------------------------------------------------------
        Get order
        ------------------------------------------------------------
        */

        $order =
            $this->orderModel
                ->getOrderById(
                    $orderId,
                    $userId
                );


        if ($order === false) {

            die("Order not found.");
        }


        /*
        ------------------------------------------------------------
        Get order items
        ------------------------------------------------------------
        */

        $items =
            $this->orderModel
                ->getOrderItems(
                    $orderId
                );


        /*
        ------------------------------------------------------------
        Get shipping address
        ------------------------------------------------------------
        */

        $address =
            $this->orderModel
                ->getShippingAddress(
                    $order["shipping_address_id"],
                    $userId
                );


        require
            "views/customer/order-details.php";
    }
}

?>