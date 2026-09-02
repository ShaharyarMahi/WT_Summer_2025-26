<?php

$currentPage = $_GET["page"] ?? "customer";

?>

<aside class="dashboard-sidebar">

    <nav class="dashboard-nav" aria-label="Customer navigation">


        <!-- DASHBOARD -->

        <a
            class="dashboard-nav-item <?php echo ($currentPage === 'customer') ? 'active' : ''; ?>"
            href="index.php?page=customer"
        >
            Dashboard
        </a>


        <!-- MY ORDERS -->

        <a
            class="dashboard-nav-item <?php echo ($currentPage === 'orders') ? 'active' : ''; ?>"
            href="index.php?page=orders"
        >
            My Orders
        </a>


        <!-- MY ADDRESSES -->

        <a
            class="dashboard-nav-item <?php echo ($currentPage === 'addresses') ? 'active' : ''; ?>"
            href="index.php?page=addresses"
        >
            My Addresses
        </a>


        <!-- WISHLIST -->

        <a
            class="dashboard-nav-item <?php echo ($currentPage === 'wishlist') ? 'active' : ''; ?>"
            href="index.php?page=wishlist"
        >
            Wishlist
        </a>


        <!-- PROFILE -->

        <a
            class="dashboard-nav-item <?php echo ($currentPage === 'profile') ? 'active' : ''; ?>"
            href="index.php?page=profile"
        >
            Profile
        </a>


        <!-- CHANGE PASSWORD -->

        <a
            class="dashboard-nav-item"
            href="index.php?page=profile#password"
        >
            Change Password
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