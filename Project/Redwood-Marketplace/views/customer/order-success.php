<?php

$pageTitle = "Order Successful";

require "includes/header.php";
require "includes/navbar.php";

?>

<main>

    <h1>Order Placed Successfully!</h1>


    <p>
        Thank you for shopping with Redwood Marketplace.
    </p>


    <p>

        <strong>
            Order Number:
        </strong>

        <?php echo htmlspecialchars(
            $order["order_number"]
        ); ?>

    </p>


    <p>

        <strong>
            Order Status:
        </strong>

        <?php echo htmlspecialchars(
            $order["order_status"]
        ); ?>

    </p>


    <p>

        <strong>
            Total:
        </strong>

        ৳<?php echo number_format(
            $order["total_amount"],
            2
        ); ?>

    </p>


    <p>

        <a
            href="index.php?page=orders"
        >
            View My Orders
        </a>

    </p>


    <p>

        <a
            href="index.php?page=products"
        >
            Continue Shopping
        </a>

    </p>

</main>

<?php

require "includes/footer.php";

?>