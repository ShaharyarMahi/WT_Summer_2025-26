<?php

$pageTitle = "Checkout";

require "includes/header.php";
require "includes/navbar.php";

?>

<main>

    <h1>Checkout</h1>


    <!-- ========================= -->
    <!-- DELIVERY ADDRESS -->
    <!-- ========================= -->

    <section>

        <h2>Delivery Address</h2>


        <?php if ($addresses->num_rows === 0): ?>

            <p>
                You don't have a saved address.
            </p>


            <p>
                <a href="index.php?page=addresses">
                    Add an Address
                </a>
            </p>


        <?php else: ?>

            <form
                method="POST"
                action="index.php?page=place-order"
            >

                <?php while (
                    $address = $addresses->fetch_assoc()
                ): ?>

                    <div>

                        <label>

                            <input
                                type="radio"
                                name="address_id"
                                value="<?php echo
                                    (int)$address["address_id"];
                                ?>"
                                <?php
                                echo $address["is_default"]
                                    ? "checked"
                                    : "";
                                ?>
                                required
                            >

                            <strong>

                                <?php echo htmlspecialchars(
                                    $address["address_type"]
                                ); ?>

                            </strong>

                        </label>


                        <p>

                            <?php echo htmlspecialchars(
                                $address["full_name"]
                            ); ?>

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

                        <hr>

                    </div>

                <?php endwhile; ?>


                <!-- ========================= -->
                <!-- ORDER SUMMARY -->
                <!-- ========================= -->

                <h2>Order Summary</h2>


                <?php while (
                    $item = $cartItems->fetch_assoc()
                ): ?>

                    <?php

                    $itemTotal =
                        $item["price"]
                        * $item["quantity"];

                    ?>

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
                                $item["price"],
                                2
                            ); ?>

                        </p>


                        <p>

                            Item Total:
                            ৳<?php echo number_format(
                                $itemTotal,
                                2
                            ); ?>

                        </p>

                    </div>

                    <hr>

                <?php endwhile; ?>


                <!-- ========================= -->
                <!-- PRICE SUMMARY -->
                <!-- ========================= -->

                <section>

                    <h2>Payment Summary</h2>


                    <p>

                        Subtotal:

                        <strong>

                            ৳<?php echo number_format(
                                $subtotal,
                                2
                            ); ?>

                        </strong>

                    </p>


                    <p>

                        Shipping Fee:

                        <strong>

                            ৳<?php echo number_format(
                                $shippingFee,
                                2
                            ); ?>

                        </strong>

                    </p>


                    <p>

                        Discount:

                        <strong>

                            - ৳<?php echo number_format(
                                $discount,
                                2
                            ); ?>

                        </strong>

                    </p>


                    <hr>


                    <h2>

                        Total:

                        ৳<?php echo number_format(
                            $totalAmount,
                            2
                        ); ?>

                    </h2>

                </section>


                <button type="submit">
                    Place Order
                </button>

            </form>

        <?php endif; ?>

    </section>

</main>

<?php

require "includes/footer.php";

?>