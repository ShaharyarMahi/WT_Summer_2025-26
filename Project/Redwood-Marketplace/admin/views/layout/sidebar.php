<?php
$currentPage = $_GET['page'] ?? 'dashboard';
?>
<div class="sidebar">
    <h3>Admin Panel</h3>
    <ul>
        <li>
            <a href="index.php?page=dashboard" class="<?= $currentPage === 'dashboard' ? 'active' : '' ?>">
                Dashboard
            </a>
        </li>
        <li>
            <a href="index.php?page=categories" class="<?= $currentPage === 'categories' ? 'active' : '' ?>">
                Categories
            </a>
        </li>
        <li>
            <a href="index.php?page=products" class="<?= $currentPage === 'products' ? 'active' : '' ?>">
                Products
            </a>
        </li>
        <li>
            <a href="index.php?page=orders" class="<?= $currentPage === 'orders' ? 'active' : '' ?>">
                Orders
            </a>
        </li>
        <li>
            <a href="index.php?page=customers" class="<?= $currentPage === 'customers' ? 'active' : '' ?>">
                Customers
            </a>
        </li>
        <li>
            <a href="index.php?page=sellers" class="<?= $currentPage === 'sellers' ? 'active' : '' ?>">
                Sellers
            </a>
        </li>
        <li>
            <a href="index.php?page=reviews" class="<?= $currentPage === 'reviews' ? 'active' : '' ?>">
                Reviews
            </a>
        </li>
    </ul>
</div>
