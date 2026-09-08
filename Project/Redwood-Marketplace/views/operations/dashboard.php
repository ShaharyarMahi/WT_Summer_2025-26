<?php

$pageTitle = "Operations Dashboard";

require "includes/header.php";
require "includes/navbar.php";

?>

<main class="dashboard-page">

    <?php require "includes/operations-sidebar.php"; ?>


    <section class="dashboard-content">

        <div class="orders-header">

            <h1>
                Welcome, <?php echo htmlspecialchars($_SESSION["first_name"] ?? "Staff"); ?>
            </h1>

        </div>

    </section>

</main>


<?php

require "includes/footer.php";

?>
