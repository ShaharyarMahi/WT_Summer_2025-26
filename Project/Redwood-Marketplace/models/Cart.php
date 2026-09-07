<?php

class Cart
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getConnection()
    {
        return $this->conn;
    }


    public function getCartByUser($userId)
    {
        $sql = "SELECT
                    cart_id,
                    user_id,
                    created_at,
                    updated_at
                FROM carts
                WHERE user_id = ?
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $userId);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            return $result->fetch_assoc();
        }

        return false;
    }


    public function createCart($userId)
    {
        $sql = "INSERT INTO carts (user_id)
                VALUES (?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            return $stmt->insert_id;
        }

        return false;
    }


    public function getCartItem($cartId, $productId)
    {
        $sql = "SELECT
                    cart_item_id,
                    cart_id,
                    product_id,
                    quantity,
                    added_at
                FROM cart_items
                WHERE cart_id = ?
                AND product_id = ?
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "ii",
            $cartId,
            $productId
        );

        
        
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            return $result->fetch_assoc();
        }

        return false;
    }

    public function getCartItems($cartId)
    {
        $sql = "SELECT
                    ci.cart_item_id,
                    ci.product_id,
                    ci.quantity,
                    p.product_name,
                    p.price,
                    p.brand,
                    c.category_name
                FROM cart_items ci
                INNER JOIN products p
                    ON ci.product_id = p.product_id
                LEFT JOIN categories c
                    ON p.category_id = c.category_id
                WHERE ci.cart_id = ?
                ORDER BY ci.cart_item_id ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $cartId);
        $stmt->execute();

        return $stmt->get_result();
    }


    public function addItem($cartId, $productId, $quantity = 1)
    {
        $sql = "INSERT INTO cart_items
                (cart_id, product_id, quantity)
                VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "iii",
            $cartId,
            $productId,
            $quantity
        );

        return $stmt->execute();
    }


    public function updateItem($userId, $cartItemId, $quantity)
{
    $sql = "UPDATE cart_items ci
            INNER JOIN carts c
                ON ci.cart_id = c.cart_id
            SET ci.quantity = ?,
                c.updated_at = CURRENT_TIMESTAMP
            WHERE ci.cart_item_id = ?
            AND c.user_id = ?";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param(
        "iii",
        $quantity,
        $cartItemId,
        $userId
    );

    return $stmt->execute();
}



public function removeItem($userId, $cartItemId)
{
    $sql = "DELETE ci
            FROM cart_items ci
            INNER JOIN carts c
                ON ci.cart_id = c.cart_id
            WHERE ci.cart_item_id = ?
            AND c.user_id = ?";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param(
        "ii",
        $cartItemId,
        $userId
    );

    return $stmt->execute();
}


    public function updateItemQuantity(
        $cartItemId,
        $quantity
    ) {
        $sql = "UPDATE cart_items
                SET quantity = ?
                WHERE cart_item_id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "ii",
            $quantity,
            $cartItemId
        );

        return $stmt->execute();
    }
}

?>