<?php

require_once "models/Seller.php";
require_once "models/Product.php";
require_once "models/Order.php";

class SellerController
{
    private $conn;
    private $sellerModel;
    private $productModel;
    private $orderModel;


    /*
    |--------------------------------------------------------------------------
    | Constructor
    |--------------------------------------------------------------------------
    */

    public function __construct($conn)
    {
        $this->conn = $conn;

        $this->sellerModel =
            new Seller($conn);

        $this->productModel =
            new Product($conn);

        $this->orderModel =
            new Order($conn);
    }


    /*
    |--------------------------------------------------------------------------
    | Check Seller Login
    |--------------------------------------------------------------------------
    */

    private function requireSeller()
    {
        if (
            !isset($_SESSION["user_id"]) ||
            !isset($_SESSION["role"])
        ) {

            header(
                "Location: index.php?page=login"
            );

            exit;
        }


        if ($_SESSION["role"] !== "seller") {

            header(
                "Location: index.php?page=customer"
            );

            exit;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Get Logged-in Seller's Store
    |--------------------------------------------------------------------------
    */

    private function getSellerStore()
    {
        $this->requireSeller();


        $sellerId =
            (int)$_SESSION["user_id"];


        $store =
            $this->sellerModel
                ->getStoreBySellerId(
                    $sellerId
                );


        if ($store === false) {

            die(
                "No store is associated with this seller account."
            );
        }


        return $store;
    }


    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        $store =
            $this->getSellerStore();


        $storeId =
            (int)$store["store_id"];


        /*
        ----------------------------------------------------
        Total Products
        ----------------------------------------------------
        */

        $sql = "
            SELECT COUNT(*) AS total
            FROM products
            WHERE store_id = ?
        ";


        $stmt =
            $this->conn->prepare($sql);


        if (!$stmt) {

            die(
                "Unable to prepare product count query."
            );
        }


        $stmt->bind_param(
            "i",
            $storeId
        );


        $stmt->execute();


        $row =
            $stmt->get_result()
                ->fetch_assoc();


        $totalProducts =
            (int)($row["total"] ?? 0);


        $stmt->close();


        /*
        ----------------------------------------------------
        Low Stock Products
        ----------------------------------------------------
        */

        $sql = "
            SELECT COUNT(*) AS total
            FROM products
            WHERE store_id = ?
            AND stock_quantity <= low_stock_threshold
        ";


        $stmt =
            $this->conn->prepare($sql);


        if (!$stmt) {

            die(
                "Unable to prepare low stock query."
            );
        }


        $stmt->bind_param(
            "i",
            $storeId
        );


        $stmt->execute();


        $row =
            $stmt->get_result()
                ->fetch_assoc();


        $lowStock =
            (int)($row["total"] ?? 0);


        $stmt->close();


        /*
        ----------------------------------------------------
        Total Orders
        ----------------------------------------------------
        */

        $sql = "
            SELECT COUNT(DISTINCT order_id) AS total
            FROM order_items
            WHERE store_id = ?
        ";


        $stmt =
            $this->conn->prepare($sql);


        if (!$stmt) {

            die(
                "Unable to prepare order count query."
            );
        }


        $stmt->bind_param(
            "i",
            $storeId
        );


        $stmt->execute();


        $row =
            $stmt->get_result()
                ->fetch_assoc();


        $totalOrders =
            (int)($row["total"] ?? 0);


        $stmt->close();


        /*
        ----------------------------------------------------
        Total Seller Sales
        ----------------------------------------------------
        */

        $sql = "
            SELECT COALESCE(
                SUM(subtotal),
                0
            ) AS total
            FROM order_items
            WHERE store_id = ?
        ";


        $stmt =
            $this->conn->prepare($sql);


        if (!$stmt) {

            die(
                "Unable to prepare sales query."
            );
        }


        $stmt->bind_param(
            "i",
            $storeId
        );


        $stmt->execute();


        $row =
            $stmt->get_result()
                ->fetch_assoc();


        $totalSales =
            (float)($row["total"] ?? 0);


        $stmt->close();


        /*
        ----------------------------------------------------
        Recent Orders
        ----------------------------------------------------
        */

        $recentOrders =
            $this->orderModel
                ->getOrdersByStore(
                    $storeId
                );


        /*
        ----------------------------------------------------
        Load Dashboard View
        ----------------------------------------------------
        */

        require "views/seller/dashboard.php";
    }


    /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    */

    public function products()
    {
        $store = $this->getSellerStore();
        $storeId = (int)$store["store_id"];

        $products = $this->productModel->getProductsByStore($storeId);

        require "views/seller/products.php";
    }


    /*
    |--------------------------------------------------------------------------
    | Add Product Page
    |--------------------------------------------------------------------------
    */

    public function addProduct()
    {
        $this->getSellerStore();

        $categories = $this->productModel->getAllCategories();

        require "views/seller/add-product.php";
    }


    /*
    |--------------------------------------------------------------------------
    | Save New Product
    |--------------------------------------------------------------------------
    */

    public function storeProduct()
    {
        $store =
            $this->getSellerStore();


        if (
            $_SERVER["REQUEST_METHOD"]
            !== "POST"
        ) {

            header(
                "Location: index.php?page=seller-products"
            );

            exit;
        }


        $storeId =
            (int)$store["store_id"];


        /*
        Get form values
        */

        $productName =
            trim(
                $_POST["product_name"] ?? ""
            );


        $sku =
            trim(
                $_POST["sku"] ?? ""
            );


        $categoryId =
            (int)(
                $_POST["category_id"] ?? 0
            );


        $brand =
            trim(
                $_POST["brand"] ?? ""
            );


        $description =
            trim(
                $_POST["description"] ?? ""
            );


        $price =
            (float)(
                $_POST["price"] ?? 0
            );


        $comparePrice =
            (float)(
                $_POST["compare_price"] ?? 0
            );


        $stockQuantity =
            (int)(
                $_POST["stock_quantity"] ?? 0
            );


        $lowStockThreshold =
            (int)(
                $_POST["low_stock_threshold"] ?? 5
            );


        $status =
            $_POST["status"] ?? "draft";


        /*
        Validate required fields
        */

        if (
            $productName === ""
            || $sku === ""
            || $categoryId <= 0
            || $description === ""
            || $price <= 0
            || $stockQuantity < 0
        ) {

            die(
                "Please complete all required product fields."
            );
        }


        /*
        Validate product status
        */

        $allowedStatuses = [
            "draft",
            "active",
            "inactive",
            "out_of_stock"
        ];


        if (
            !in_array(
                $status,
                $allowedStatuses,
                true
            )
        ) {

            $status = "draft";
        }


        /*
        Create product
        */

        $success =
            $this->productModel
                ->createSellerProduct(
                    $storeId,
                    $categoryId,
                    $productName,
                    $sku,
                    $brand,
                    $description,
                    $price,
                    $comparePrice,
                    $stockQuantity,
                    $lowStockThreshold,
                    $status
                );


        if (!$success) {

            die(
                "Unable to create product."
            );
        }


        header(
            "Location: index.php?page=seller-products"
        );

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Product
    |--------------------------------------------------------------------------
    */

    public function editProduct()
    {
        $store = $this->getSellerStore();
        $productId = (int)($_GET["id"] ?? 0);

        if ($productId <= 0) {
            header("Location: index.php?page=seller-products");
            exit;
        }

        $product = $this->productModel->getSellerProductById(
            $productId,
            (int)$store["store_id"]
        );

        if ($product === false) {
            die("Product not found.");
        }

        $categories = $this->productModel->getAllCategories();

        require "views/seller/edit-product.php";
    }


    /*
    |--------------------------------------------------------------------------
    | Update Product
    |--------------------------------------------------------------------------
    */

    public function updateProduct()
    {
        $store =
            $this->getSellerStore();


        if (
            $_SERVER["REQUEST_METHOD"]
            !== "POST"
        ) {

            header(
                "Location: index.php?page=seller-products"
            );

            exit;
        }


        $productId =
            (int)(
                $_POST["product_id"] ?? 0
            );


        $storeId =
            (int)$store["store_id"];


        $productName =
            trim(
                $_POST["product_name"] ?? ""
            );


        $sku =
            trim(
                $_POST["sku"] ?? ""
            );


        $categoryId =
            (int)(
                $_POST["category_id"] ?? 0
            );


        $brand =
            trim(
                $_POST["brand"] ?? ""
            );


        $description =
            trim(
                $_POST["description"] ?? ""
            );


        $price =
            (float)(
                $_POST["price"] ?? 0
            );


        $comparePrice =
            (float)(
                $_POST["compare_price"] ?? 0
            );


        $stockQuantity =
            (int)(
                $_POST["stock_quantity"] ?? 0
            );


        $lowStockThreshold =
            (int)(
                $_POST["low_stock_threshold"] ?? 5
            );


        $status =
            $_POST["status"] ?? "draft";


        /*
        Validate
        */

        if (
            $productId <= 0
            || $productName === ""
            || $sku === ""
            || $categoryId <= 0
            || $description === ""
            || $price <= 0
            || $stockQuantity < 0
        ) {

            die(
                "Invalid product information."
            );
        }


        /*
        Make sure product belongs
        to this seller's store.
        */

        $existing =
            $this->productModel
                ->getSellerProductById(
                    $productId,
                    $storeId
                );


        if ($existing === false) {

            die(
                "Product not found."
            );
        }


        /*
        Update product
        */

        $success =
            $this->productModel
                ->updateSellerProduct(
                    $productId,
                    $storeId,
                    $categoryId,
                    $productName,
                    $sku,
                    $brand,
                    $description,
                    $price,
                    $comparePrice,
                    $stockQuantity,
                    $lowStockThreshold,
                    $status
                );


        if (!$success) {

            die(
                "Unable to update product."
            );
        }


        header(
            "Location: index.php?page=seller-products"
        );

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Seller Orders
    |--------------------------------------------------------------------------
    */

    public function orders()
    {
        $store = $this->getSellerStore();

        $orders = $this->orderModel->getOrdersByStore(
            (int)$store["store_id"]
        );

        require "views/seller/orders.php";
    }
}