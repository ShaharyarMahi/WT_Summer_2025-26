<?php

$pageTitle = "My Orders";

require "includes/header.php";
require "includes/navbar.php";

?>

<main class="dashboard-page">

    <?php require "includes/customer-sidebar.php"; ?>


    <section class="dashboard-content">

        <div class="orders-header">

            <h1>My Orders</h1>

            <p>
                View and track all your orders.
            </p>

        </div>


        <?php if ($orders->num_rows === 0): ?>

            <div class="no-orders">

                <h2>No Orders Yet</h2>

                <p>
                    You haven't placed any orders yet.
                </p>

                <a href="index.php?page=products">
                    Start Shopping
                </a>

            </div>


        <?php else: ?>


            <div class="orders-table-wrapper">

                <table class="orders-table">

                    <thead>

                        <tr>

                            <th>Order ID</th>

                            <th>Date</th>

                            <th>Total</th>

                            <th>Status</th>

                            <th>Action</th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php while (
                            $order = $orders->fetch_assoc()
                        ): ?>

                            <tr>

                                <!-- Order ID -->

                                <td>

                                    #
                                    <?php echo htmlspecialchars(
                                        $order["order_number"]
                                    ); ?>

                                </td>


                                <!-- Date -->

                                <td>

                                    <?php echo htmlspecialchars(
                                        date(
                                            "M d, Y",
                                            strtotime(
                                                $order["created_at"]
                                            )
                                        )
                                    ); ?>

                                </td>


                                <!-- Total -->

                                <td>

                                    BDT <?php echo number_format(
                                        $order["total_amount"],
                                        2
                                    ); ?>

                                </td>


                                <!-- Status -->

                                <td>

                                    <span
                                        class="order-status
                                        status-<?php echo strtolower(
                                            htmlspecialchars(
                                                $order["order_status"]
                                            )
                                        ); ?>"
                                    >

                                        <?php echo htmlspecialchars(
                                            ucfirst(
                                                $order["order_status"]
                                            )
                                        ); ?>

                                    </span>

                                </td>


                                <!-- Action -->

                                <td>

                                    <a
                                        class="order-details-button"
                                        href="index.php?page=order-details&id=<?php
                                            echo (int)$order["order_id"];
                                        ?>"
                                    >

                                        View Details

                                    </a>

                                </td>

                            </tr>


                        <?php endwhile; ?>

                    </tbody>

                </table>

            </div>


        <?php endif; ?>

    </section>

</main>


<?php

require "includes/footer.php";

?>