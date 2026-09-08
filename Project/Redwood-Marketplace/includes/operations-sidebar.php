<?php

$currentPage = $_GET["page"] ?? "operations";

?>

<aside class="dashboard-sidebar">

    <nav class="dashboard-nav" aria-label="Operations navigation">


        <!-- DASHBOARD -->

        <a
            class="dashboard-nav-item <?php echo ($currentPage === 'operations') ? 'active' : ''; ?>"
            href="index.php?page=operations"
        >
            Dashboard
        </a>


        <!-- MANAGE ORDERS -->

        <a
            class="dashboard-nav-item <?php echo ($currentPage === 'manage-orders') ? 'active' : ''; ?>"
            href="index.php?page=manage-orders"
        >
            Manage Orders
        </a>


        <hr>


        <!-- LOGOUT -->

        <a
            class="dashboard-nav-item"
            href="index.php?page=logout"
        >
            Logout
        </a>

    </nav>

</aside>
