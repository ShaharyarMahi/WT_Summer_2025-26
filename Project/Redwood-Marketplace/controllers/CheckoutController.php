<?php

require_once "models/Checkout.php";
require_once "models/Cart.php";
require_once "config/auth.php";

class CheckoutController
{
    private $checkoutModel;
    private $cartModel;

    public function __construct($conn)
    {
        $this->checkoutModel = new Checkout($conn);

        $this->cartModel = new Cart($conn);
    }



    public function placeOrder()
{
    requireLogin();


    if ($_SERVER["REQUEST_METHOD"] !== "POST") {

        header("Location: index.php?page=checkout");

        exit;
    }


    $userId = (int)$_SESSION["user_id"];


    $addressId = (int)(
        $_POST["address_id"] ?? 0
    );


    if ($addressId <= 0) {

        header(
            "Location: index.php?page=checkout"
        );

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Verify address ownership
    |--------------------------------------------------------------------------
    */

    if (
        !$this->checkoutModel
            ->addressBelongsToUser(
                $addressId,
                $userId
            )
    ) {

        die(
            "Invalid shipping address."
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Get user's cart
    |--------------------------------------------------------------------------
    */

    $cart =
        $this->cartModel
            ->getCartByUser($userId);


    if ($cart === false) {

        die("Cart not found.");
    }


 // Validate user login credentials

    $result =
        $this->checkoutModel
            ->createOrder(
                $userId,
                $addressId,
                $cart["cart_id"],
                100,
                0
            );


 ------------------------------------------------------------------------
    */

    if ($result["success"]) {

        header(
            "Location: index.php?page=order-success&id="
            . $result["order_id"]
        );

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Failure
    |--------------------------------------------------------------------------
    */

    echo "Order could not be placed.";

    echo "<br><br>";

    echo htmlspecialchars(
        $result["message"]
    );
}


public function orderSuccess()
{
    requireLogin();

    $userId =
        (int)$_SESSION["user_id"];


    $orderId =
        (int)($_GET["id"] ?? 0);


    if ($orderId <= 0) {

        header(
            "Location: index.php?page=products"
        );

        exit;
    }


    $order =
        $this->checkoutModel
            ->getOrderById(
                $orderId,
                $userId
            );


    if ($order === false) {

        die("Order not found.");
    }


    require "views/customer/order-success.php";
}


    public function index()
    {
        requireLogin();

        $userId = (int)$_SESSION["user_id"];


        // Get customer's cart

        $cart = $this->cartModel->getCartByUser($userId);


        if ($cart === false) {

            header("Location: index.php?page=cart");

            exit;
        }


        // Get cart items

        $cartItems = $this->cartModel->getCartItems(
            $cart["cart_id"]
        );


        // Empty cart protection

        if ($cartItems->num_rows === 0) {

            header("Location: index.php?page=cart");

            exit;
        }


        // Get customer's addresses

        $addresses =
            $this->checkoutModel->getUserAddresses(
                $userId
            );


        // Calculate subtotal

        $subtotal = 0;


        while ($item = $cartItems->fetch_assoc()) {

            $subtotal +=
                $item["price"] * $item["quantity"];
        }


        // We consumed the result above.
        // Get the cart items again for the view.

        $cartItems = $this->cartModel->getCartItems(
            $cart["cart_id"]
        );


        // Current project shipping rule

        $shippingFee = 100;


        $discount = 0;


        $totalAmount =
            $subtotal
            + $shippingFee
            - $discount;


        require "views/customer/checkout.php";
    }
}

?>