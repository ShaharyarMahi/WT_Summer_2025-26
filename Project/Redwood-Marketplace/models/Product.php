<?php

class Product
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllProducts()
    {
        $sql = "SELECT
                    p.product_id,
                    p.product_name,
                    p.description,
                    p.price,
                    p.brand,
                    p.category_id,
                    c.category_name
                FROM products p
                LEFT JOIN categories c
                    ON p.category_id = c.category_id
                ORDER BY p.product_id DESC";

        return $this->conn->query($sql);
    }

    public function getProductsByIds($productIds)
    {
        if (empty($productIds)) {
            return [];
        }

        $placeholders = implode(", ", array_fill(0, count($productIds), "?"));

        $sql = "SELECT
                    p.product_id,
                    p.product_name,
                    p.description,
                    p.price,
                    p.brand,
                    p.category_id,
                    c.category_name
                FROM products p
                LEFT JOIN categories c
                    ON p.category_id = c.category_id
                WHERE p.product_id IN (" . $placeholders . ")
                ORDER BY p.product_id DESC";

        $stmt = $this->conn->prepare($sql);

        $types = str_repeat("i", count($productIds));
        $stmt->bind_param($types, ...$productIds);
        $stmt->execute();

        return $stmt->get_result();
    }

public function getProductById($productId)
{
    $sql = "SELECT
                p.product_id,
                p.product_name,
                p.description,
                p.price,
                p.brand,
                p.category_id,
                c.category_name
            FROM products p
            LEFT JOIN categories c
                ON p.category_id = c.category_id
            WHERE p.product_id = ?
            LIMIT 1";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param("i", $productId);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        return $result->fetch_assoc();
    }

    return false;
}


public function getProductImages($productId)
{
    $sql = "SELECT
                image_id,
                product_id,
                image_path,
                is_primary,
                created_at
            FROM product_images
            WHERE product_id = ?
            ORDER BY is_primary DESC, image_id ASC";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param("i", $productId);

    $stmt->execute();

    $result = $stmt->get_result();

    return $result;
}



}

?>