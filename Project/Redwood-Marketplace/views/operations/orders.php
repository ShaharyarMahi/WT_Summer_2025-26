<?php

$pageTitle = "Manage Orders";

require "includes/header.php";
require "includes/navbar.php";

?>

<main class="dashboard-page">

    <?php require "includes/operations-sidebar.php"; ?>


    <section class="dashboard-content">

        <div class="orders-header">

            <h1>Manage Orders</h1>

            <p>
                View all customer orders and update their status.
            </p>

        </div>


        <?php if ($orders->num_rows === 0): ?>

            <div class="no-orders">

                <h2>No Orders Yet</h2>

                <p>
                    There are no orders in the system yet.
                </p>

            </div>


        <?php else: ?>


            <div class="orders-table-wrapper">

                <table class="orders-table">

                    <thead>

                        <tr>

                            <th>Order ID</th>

                            <th>Customer</th>

                            <th>Date</th>

                            <th>Total</th>

                            <th>Status</th>

                            <th>Update</th>

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


                                <!-- Customer -->

                                <td>

                                    <?php echo htmlspecialchars(
                                        trim(
                                            ($order["first_name"] ?? "") . " " . ($order["last_name"] ?? "")
                                        )
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


                                <!-- Update -->

                                <td>

                                    <form
                                        method="POST"
                                        action="index.php?page=update-order-status"
                                    >

                                        <input
                                            type="hidden"
                                            name="order_id"
                                            value="<?php echo (int)$order["order_id"]; ?>"
                                        >

                                        <select name="status">

                                            <?php foreach ([
                                                "pending",
                                                "processing",
                                                "shipped",
                                                "delivered",
                                                "cancelled",
                                                "returned"
                                            ] as $status): ?>

                                                <option
                                                    value="<?php echo $status; ?>"
                                                    <?php echo ($order["order_status"] === $status) ? "selected" : ""; ?>
                                                >
                                                    <?php echo ucfirst($status); ?>
                                                </option>

                                            <?php endforeach; ?>

                                        </select>

                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                        >
                                            Update
                                        </button>

                                    </form>

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
