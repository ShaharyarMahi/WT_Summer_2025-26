<?php

$pageTitle = "Customer Dashboard";

require "includes/header.php";
require "includes/navbar.php";

?>

<main class="dashboard-page">

    <?php require "includes/customer-sidebar.php"; ?>


    <section class="dashboard-content">

        <div class="dashboard-welcome">

            <h1>
                Welcome back,
                <?php echo htmlspecialchars($_SESSION["first_name"]); ?>!
            </h1>

        </div>


        <div class="quick-overview">

            <h2>Quick Overview</h2>

            <div class="overview-info">

                <div class="overview-item">

                    <strong>1</strong>

                    <span>
                        Total Orders
                    </span>

                </div>


                <div class="overview-item">

                    <strong>1</strong>

                    <span>
                        Pending Orders
                    </span>

                </div>


                <div class="overview-item">

                    <strong>0</strong>

                    <span>
                        Delivered Orders
                    </span>

                </div>


                <div class="overview-item">

                    <strong>0</strong>

                    <span>
                        Wishlist Items
                    </span>

                </div>

            </div>

        </div>

    </section>

</main>


<?php

require "includes/footer.php";

?>