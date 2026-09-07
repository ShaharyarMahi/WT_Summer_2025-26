<?php

class Checkout
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }


 

    public function getUserAddresses($userId)
    {
        $sql = "SELECT
                    address_id,
                    user_id,
                    address_type,
                    full_name,
                    phone,
                    address_line,
                    city,
                    postal_code,
                    country,
                    is_default
                FROM addresses
                WHERE user_id = ?
                ORDER BY is_default DESC, address_id DESC";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $userId);

        $stmt->execute();

        return $stmt->get_result();
    }


    

    public function addressBelongsToUser(
        $addressId,
        $userId
    ) {
        $sql = "SELECT address_id
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

        return $result->num_rows === 1;
    }




    public function createOrder(
        $userId,
        $addressId,
        $cartId,
        $shippingFee = 100,
        $discount = 0
    ) {

       

        $this->conn->begin_transaction();


        try {

           

            $sql = "SELECT
                        ci.cart_item_id,
                        ci.product_id,
                        ci.quantity,

                        p.store_id,
                        p.product_name,
                        p.price,
                        p.stock_quantity,
                        p.status

                    FROM cart_items ci

                    INNER JOIN products p
                        ON ci.product_id = p.product_id

                    WHERE ci.cart_id = ?

                    FOR UPDATE";


            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param(
                "i",
                $cartId
            );

            $stmt->execute();

            $result = $stmt->get_result();



            if ($result->num_rows === 0) {

                throw new Exception(
                    "Your cart is empty."
                );
            }


           

            $subtotal = 0;

            $items = [];


            while ($item = $result->fetch_assoc()) {


                if ($item["status"] !== "active") {

                    throw new Exception(
                        "A product in your cart is no longer available."
                    );
                }


               

                if (
                    $item["quantity"]
                    > $item["stock_quantity"]
                ) {

                    throw new Exception(
                        "Insufficient stock for "
                        . $item["product_name"]
                    );
                }



                $itemSubtotal =
                    $item["price"]
                    * $item["quantity"];


                $subtotal += $itemSubtotal;


                

                $item["item_subtotal"] =
                    $itemSubtotal;


                $items[] = $item;
            }


           

            $totalAmount =
                $subtotal
                + $shippingFee
                - $discount;



            $orderNumber =
                "RWM-"
                . date("Ymd-His")
                . "-"
                . strtoupper(
                    bin2hex(random_bytes(3))
                );


            

            $sql = "INSERT INTO orders
                    (
                        user_id,
                        shipping_address_id,
                        order_number,
                        subtotal,
                        shipping_fee,
                        discount,
                        total_amount,
                        order_status
                    )
                    VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')";


            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param(
                "iisdddd",
                $userId,
                $addressId,
                $orderNumber,
                $subtotal,
                $shippingFee,
                $discount,
                $totalAmount
            );


            if (!$stmt->execute()) {

                throw new Exception(
                    "Unable to create order."
                );
            }


            /*
            --------------------------------------------------------
            Get generated order ID
            --------------------------------------------------------
            */

            $orderId =
                $stmt->insert_id;


            /*
            --------------------------------------------------------
            Prepare order_items INSERT
            --------------------------------------------------------
            */

            $sql = "INSERT INTO order_items
                    (
                        order_id,
                        product_id,
                        store_id,
                        product_name,
                        unit_price,
                        quantity,
                        subtotal,
                        item_status
                    )
                    VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')";


            $itemStmt =
                $this->conn->prepare($sql);


            /*
            --------------------------------------------------------
            Insert every order item
            --------------------------------------------------------
            */

            foreach ($items as $item) {

                $itemStmt->bind_param(
                    "iiisdis",
                    $orderId,
                    $item["product_id"],
                    $item["store_id"],
                    $item["product_name"],
                    $item["price"],
                    $item["quantity"],
                    $item["item_subtotal"]
                );


                if (!$itemStmt->execute()) {

                    throw new Exception(
                        "Unable to create order item."
                    );
                }


                /*
                ----------------------------------------------------
                Reduce product stock
                ----------------------------------------------------
                */

                $stockSql =
                    "UPDATE products
                     SET stock_quantity =
                         stock_quantity - ?
                     WHERE product_id = ?
                     AND stock_quantity >= ?";


                $stockStmt =
                    $this->conn->prepare(
                        $stockSql
                    );


                $stockStmt->bind_param(
                    "iii",
                    $item["quantity"],
                    $item["product_id"],
                    $item["quantity"]
                );


                if (!$stockStmt->execute()) {

                    throw new Exception(
                        "Unable to update product stock."
                    );
                }


                if (
                    $stockStmt->affected_rows !== 1
                ) {

                    throw new Exception(
                        "Stock changed while placing the order."
                    );
                }
            }


            /*
            --------------------------------------------------------
            Clear cart
            --------------------------------------------------------
            */

            $deleteSql =
                "DELETE FROM cart_items
                 WHERE cart_id = ?";


            $deleteStmt =
                $this->conn->prepare(
                    $deleteSql
                );


            $deleteStmt->bind_param(
                "i",
                $cartId
            );


            if (!$deleteStmt->execute()) {

                throw new Exception(
                    "Unable to clear cart."
                );
            }


            /*
            --------------------------------------------------------
            Everything succeeded
            --------------------------------------------------------
            */

            $this->conn->commit();


            return [
                "success" => true,
                "order_id" => $orderId,
                "order_number" => $orderNumber,
                "subtotal" => $subtotal,
                "shipping_fee" => $shippingFee,
                "discount" => $discount,
                "total_amount" => $totalAmount
            ];


        } catch (Exception $e) {

            /*
            --------------------------------------------------------
            Something failed → undo everything
            --------------------------------------------------------
            */

            $this->conn->rollback();


            return [
                "success" => false,
                "message" => $e->getMessage()
            ];
        }
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
                created_at
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
}

?>