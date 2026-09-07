<?php

require_once "models/Product.php";

class ProductController
{
    private $productModel;

    public function __construct($conn)
    {
        $this->productModel = new Product($conn);
    }

   







     public function index()
    {
        $products = $this->productModel->getAllProducts();

        $wishlistIds = $_SESSION["wishlist"] ?? [];

        require "views/customer/products.php";
    }

    public function toggleWishlist()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: index.php?page=products");
            exit;
        }

        $productId = (int)($_POST["product_id"] ?? 0);

        if ($productId <= 0) {
            header("Location: index.php?page=products");
            exit;
        }

        $wishlist = $_SESSION["wishlist"] ?? [];

        if (isset($wishlist[$productId])) {
            unset($wishlist[$productId]);
        } else {
            $wishlist[$productId] = time();
        }

        $_SESSION["wishlist"] = $wishlist;

        $redirectPage = $_POST["redirect"] ?? "products";

        header("Location: index.php?page=" . $redirectPage);
        exit;
    }

    public function wishlist()
    {
        $wishlistIds = $_SESSION["wishlist"] ?? [];

        $wishlistItems = [];

        if (!empty($wishlistIds)) {
            $productIds = array_keys($wishlistIds);
            $result = $this->productModel->getProductsByIds($productIds);

            if ($result && $result->num_rows > 0) {
                while ($product = $result->fetch_assoc()) {
                    $wishlistItems[] = $product;
                }
            }
        }

        require "views/customer/wishlist.php";
    }


public function show($productId)
{
    $product = $this->productModel->getProductById($productId);

    if ($product === false) {

        echo "Product not found.";

        return;
    }

    $wishlistIds = $_SESSION["wishlist"] ?? [];

    require "views/customer/product-details.php";
}
}

?>