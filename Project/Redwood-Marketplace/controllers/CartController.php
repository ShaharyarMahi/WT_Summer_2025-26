<?php

require_once "models/Cart.php";
require_once "config/auth.php";

class CartController
{
    private $cartModel;

    public function __construct($conn)
    {
        $this->cartModel = new Cart($conn);
    }


    public function addToCart()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {

            header("Location: index.php?page=products");

            exit;
        }

        $productId = (int)(
            $_POST["product_id"] ?? 0
        );

        if ($productId <= 0) {
            header("Location: index.php?page=products");
            exit;
        }

        $redirectPage = $_POST["redirect"] ?? "products";

        if (!isset($_SESSION["user_id"])) {
            $cart = $_SESSION["guest_cart"] ?? [];
            $cart[$productId] = (int)($cart[$productId] ?? 0) + 1;
            $_SESSION["guest_cart"] = $cart;
            header("Location: index.php?page=" . $redirectPage);
            exit;
        }

        $userId = (int)$_SESSION["user_id"];

        $cart = $this->cartModel->getCartByUser($userId);

        if ($cart === false) {
            $cartId = $this->cartModel->createCart($userId);
            if ($cartId === false) {
                echo "Unable to create cart.";
                return;
            }
        } else {
            $cartId = $cart["cart_id"];
        }

        $cartItem = $this->cartModel->getCartItem($cartId, $productId);

        if ($cartItem !== false) {
            $newQuantity = $cartItem["quantity"] + 1;
            $success = $this->cartModel->updateItemQuantity($cartItem["cart_item_id"], $newQuantity);
        } else {
            $success = $this->cartModel->addItem($cartId, $productId, 1);
        }

        if ($success) {
            header("Location: index.php?page=" . $redirectPage);
            exit;
        }

        echo "Unable to add product to cart.";
    }




    public function updateCart()
{
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: index.php?page=cart");
        exit;
    }

    $cartItemId = (int)($_POST["cart_item_id"] ?? 0);
    $quantity = (int)($_POST["quantity"] ?? 1);

    if ($cartItemId <= 0) {
        header("Location: index.php?page=cart");
        exit;
    }

    if (!isset($_SESSION["user_id"])) {
        $cart = $_SESSION["guest_cart"] ?? [];

        if ($quantity < 1) {
            unset($cart[$cartItemId]);
        } else {
            $cart[$cartItemId] = $quantity;
        }

        $_SESSION["guest_cart"] = $cart;
        header("Location: index.php?page=cart");
        exit;
    }

    $userId = (int)$_SESSION["user_id"];

    if ($quantity < 1) {
        $quantity = 1;
    }

    $this->cartModel->updateItem($userId, $cartItemId, $quantity);

    header("Location: index.php?page=cart");
    exit;
}







public function removeFromCart()
{
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: index.php?page=cart");
        exit;
    }

    $cartItemId = (int)($_POST["cart_item_id"] ?? 0);

    if ($cartItemId <= 0) {
        header("Location: index.php?page=cart");
        exit;
    }

    if (!isset($_SESSION["user_id"])) {
        $cart = $_SESSION["guest_cart"] ?? [];
        unset($cart[$cartItemId]);
        $_SESSION["guest_cart"] = $cart;
        header("Location: index.php?page=cart");
        exit;
    }

    $userId = (int)$_SESSION["user_id"];

    $this->cartModel->removeItem($userId, $cartItemId);

    header("Location: index.php?page=cart");
    exit;
}






    public function index()
{
    if (!isset($_SESSION["user_id"])) {
        $cart = $_SESSION["guest_cart"] ?? [];
        $cartItems = [];

        if (!empty($cart)) {
            $productIds = array_keys($cart);
            $productModel = new Product($this->cartModel->getConnection());
            $result = $productModel->getProductsByIds($productIds);

            if ($result && $result->num_rows > 0) {
                while ($product = $result->fetch_assoc()) {
                    $productId = (int)$product["product_id"];
                    $cartItems[] = [
                        "cart_item_id" => $productId,
                        "product_id" => $productId,
                        "product_name" => $product["product_name"],
                        "brand" => $product["brand"],
                        "price" => $product["price"],
                        "quantity" => (int)($cart[$productId] ?? 1),
                    ];
                }
            }
        }

        require "views/customer/cart.php";
        return;
    }

    $userId = (int)$_SESSION["user_id"];

    $cart = $this->cartModel->getCartByUser($userId);

    if ($cart === false) {
        $cartItems = [];
    } else {
        $cartItems = $this->cartModel->getCartItems($cart["cart_id"]);
    }

    require "views/customer/cart.php";
}
}
// Validate user login credentialsd
?>