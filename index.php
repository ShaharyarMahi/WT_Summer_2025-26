<?php

session_start();

require_once "config/database.php";

require_once "controllers/HomeController.php";
require_once "controllers/ProductController.php";
require_once "controllers/AuthController.php";
require_once "controllers/CustomerController.php";
require_once "controllers/CartController.php";
require_once "controllers/CheckoutController.php";
require_once "controllers/OrderController.php";
require_once "controllers/AddressController.php";
require_once "controllers/UserController.php";
require_once "controllers/SellerController.php";

$database = new Database();

$conn = $database->connect();


$page = $_GET['page'] ?? 'home';


if ($page === 'products') {

    $productController = new ProductController($conn);

    $productController->index();


} elseif ($page === 'login') {

    $authController = new AuthController($conn);

    $authController->login();

}elseif ($page === 'register') {

    $authController = new AuthController($conn);

    $authController->register();


} elseif ($page === 'customer') {

    $customerController = new CustomerController($conn);

    $customerController->index();

}elseif ($page === 'orders') {

    $orderController = new OrderController($conn);

    $orderController->index();

}elseif ($page === 'logout') {

    $authController = new AuthController($conn);

    $authController->logout();

}elseif ($page === 'product') {

    $productId = (int)($_GET['id'] ?? 0);

    $productController = new ProductController($conn);

    $productController->show($productId);

}elseif ($page === 'toggle-wishlist') {

    $productController = new ProductController($conn);

    $productController->toggleWishlist();

}elseif ($page === 'wishlist') {

    $productController = new ProductController($conn);

    $productController->wishlist();

}elseif ($page === 'add-to-cart') {

    $cartController = new CartController($conn);

    $cartController->addToCart();

}elseif ($page === 'cart') {

    $cartController = new CartController($conn);

    $cartController->index();

}elseif ($page === 'update-cart') {

    $cartController = new CartController($conn);

    $cartController->updateCart();

}elseif ($page === 'remove-from-cart') {

    $cartController = new CartController($conn);

    $cartController->removeFromCart();

}elseif ($page === 'checkout') {

    $checkoutController =
        new CheckoutController($conn);

    $checkoutController->index();

}elseif ($page === 'place-order') {

    $checkoutController =
        new CheckoutController($conn);

    $checkoutController->placeOrder();

}elseif ($page === 'order-success') {

    $checkoutController =
        new CheckoutController($conn);

    $checkoutController->orderSuccess();

}elseif ($page === 'order-details') {

    $orderController =
        new OrderController($conn);

    $orderController->details();

}elseif ($page === 'addresses') {

    $addressController =
        new AddressController($conn);

    $addressController->index();

}elseif ($page === 'address-create') {

    $addressController =
        new AddressController($conn);

    $addressController->create();

}elseif ($page === 'address-store') {

    $addressController =
        new AddressController($conn);

    $addressController->store();

}elseif ($page === 'address-edit') {

    $addressController =
        new AddressController($conn);

    $addressController->edit();

}elseif ($page === 'address-update') {

    $addressController =
        new AddressController($conn);

    $addressController->update();

}elseif ($page === 'address-default') {

    $addressController =
        new AddressController($conn);

    $addressController->setDefault();

}elseif ($page === 'address-delete') {

    $addressController =
        new AddressController($conn);

    $addressController->delete();

}elseif ($page === 'profile') {

    $userController =
        new UserController($conn);

    $userController->profile();


}elseif ($page === 'profile-edit') {

    $userController =
        new UserController($conn);

    $userController->editProfile();


}elseif ($page === 'profile-update') {

    $userController =
        new UserController($conn);

    $userController->updateProfile();


// ============================================================
// SELLER ROUTES
// ============================================================

} elseif ($page === 'seller') {

    $sellerController = new SellerController($conn);
    $sellerController->dashboard();

} elseif ($page === 'seller-products') {

    $sellerController = new SellerController($conn);
    $sellerController->products();

} elseif ($page === 'seller-product-create') {

    $sellerController = new SellerController($conn);
    $sellerController->addProduct();

} elseif ($page === 'seller-product-store') {

    $sellerController = new SellerController($conn);
    $sellerController->storeProduct();

} elseif ($page === 'seller-product-edit') {

    $sellerController = new SellerController($conn);
    $sellerController->editProduct();

} elseif ($page === 'seller-product-update') {

    $sellerController = new SellerController($conn);
    $sellerController->updateProduct();

} elseif ($page === 'seller-orders') {

    $sellerController = new SellerController($conn);
    $sellerController->orders();


} else {

    $homeController = new HomeController();

    $homeController->index();

}

?>