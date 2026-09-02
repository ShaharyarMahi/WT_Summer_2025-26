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

    // ============================================================
    // SELLER PRODUCT METHODS
    // ============================================================

    public function getProductsByStore($storeId)
    {
        $sql = "SELECT p.product_id, p.product_name, p.sku, p.price, p.stock_quantity,
                       p.low_stock_threshold, p.status, p.brand, p.category_id,
                       c.category_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.category_id
                WHERE p.store_id = ?
                ORDER BY p.product_id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $storeId);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getSellerProductById($productId, $storeId)
    {
        $sql = "SELECT * FROM products WHERE product_id = ? AND store_id = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $productId, $storeId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows === 1 ? $result->fetch_assoc() : false;
    }

    public function createSellerProduct($storeId, $categoryId, $name, $sku, $brand, $description,
                                         $price, $comparePrice, $stock, $lowStock, $status)
    {
        $sql = "INSERT INTO products
                (store_id, category_id, product_name, sku, brand, description,
                 price, compare_price, stock_quantity, low_stock_threshold, status, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        // Corrected type string: i i s s s s d d i i s  → "iissssddiis"
        $stmt->bind_param(
            "iissssddiis",
            $storeId, $categoryId, $name, $sku, $brand, $description,
            $price, $comparePrice, $stock, $lowStock, $status
        );
        return $stmt->execute();
    }

    public function updateSellerProduct($productId, $storeId, $categoryId, $name, $sku, $brand,
                                         $description, $price, $comparePrice, $stock, $lowStock, $status)
    {
        $sql = "UPDATE products
                SET category_id = ?, product_name = ?, sku = ?, brand = ?, description = ?,
                    price = ?, compare_price = ?, stock_quantity = ?, low_stock_threshold = ?, status = ?
                WHERE product_id = ? AND store_id = ?";
        $stmt = $this->conn->prepare($sql);
        // Corrected type string: i s s s s d d i i s i i  → "issssddiisii"
        $stmt->bind_param(
            "issssddiisii",
            $categoryId, $name, $sku, $brand, $description,
            $price, $comparePrice, $stock, $lowStock, $status, $productId, $storeId
        );
        return $stmt->execute();
    }

    public function getAllCategories()
    {
        $sql = "SELECT category_id, category_name FROM categories ORDER BY category_name";
        return $this->conn->query($sql);
    }
}