<?php

$pageTitle = "Order Details";

require "includes/header.php";
require "includes/navbar.php";

?>

<main>

    <h1>Order Details</h1>


    <!-- ================================================= -->
    <!-- ORDER INFORMATION -->
    <!-- ================================================= -->

    <section>

        <h2>
            <?php echo htmlspecialchars(
                $order["order_number"]
            ); ?>
        </h2>


        <p>

            Status:

            <strong>

                <?php echo htmlspecialchars(
                    $order["order_status"]
                ); ?>

            </strong>

        </p>


        <p>

            Order Date:

            <?php echo htmlspecialchars(
                $order["created_at"]
            ); ?>

        </p>

    </section>


    <hr>


    <!-- ================================================= -->
    <!-- SHIPPING ADDRESS -->
    <!-- ================================================= -->

    <section>

        <h2>Shipping Address</h2>


        <?php if ($address !== false): ?>

            <p>

                <strong>

                    <?php echo htmlspecialchars(
                        $address["full_name"]
                    ); ?>

                </strong>

                <br>

                <?php echo htmlspecialchars(
                    $address["phone"] ?? ""
                ); ?>

                <br>

                <?php echo htmlspecialchars(
                    $address["address_line"]
                ); ?>

                <br>

                <?php echo htmlspecialchars(
                    $address["city"]
                ); ?>

                <?php if (
                    !empty($address["postal_code"])
                ): ?>

                    -
                    <?php echo htmlspecialchars(
                        $address["postal_code"]
                    ); ?>

                <?php endif; ?>

                <br>

                <?php echo htmlspecialchars(
                    $address["country"]
                ); ?>

            </p>

        <?php endif; ?>

    </section>


    <hr>


    <!-- ================================================= -->
    <!-- ORDER ITEMS -->
    <!-- ================================================= -->

    <section>

        <h2>Items</h2>


        <?php while (
            $item = $items->fetch_assoc()
        ): ?>

            <div>

                <h3>

                    <?php echo htmlspecialchars(
                        $item["product_name"]
                    ); ?>

                </h3>


                <p>

                    Quantity:

                    <?php echo (int)$item["quantity"]; ?>

                </p>


                <p>

                    Unit Price:

                    ৳<?php echo number_format(
                        $item["unit_price"],
                        2
                    ); ?>

                </p>


                <p>

                    Subtotal:

                    ৳<?php echo number_format(
                        $item["subtotal"],
                        2
                    ); ?>

                </p>


                <p>

                    Item Status:

                    <?php echo htmlspecialchars(
                        $item["item_status"]
                    ); ?>

                </p>

            </div>

            <hr>

        <?php endwhile; ?>

    </section>


    <!-- ================================================= -->
    <!-- PRICE SUMMARY -->
    <!-- ================================================= -->

    <section>

        <h2>Payment Summary</h2>


        <p>

            Subtotal:

            ৳<?php echo number_format(
                $order["subtotal"],
                2
            ); ?>

        </p>


        <p>

            Shipping:

            ৳<?php echo number_format(
                $order["shipping_fee"],
                2
            ); ?>

        </p>


        <p>

            Discount:

            - ৳<?php echo number_format(
                $order["discount"],
                2
            ); ?>

        </p>


        <hr>


        <h2>

            Total:

            ৳<?php echo number_format(
                $order["total_amount"],
                2
            ); ?>

        </h2>

    </section>


    <br>


    <a href="index.php?page=orders">

        ← Back to My Orders

    </a>

</main>

<?php

require "includes/footer.php";

?>