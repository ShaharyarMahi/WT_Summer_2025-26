<?php
// $activeNav must be defined before including this file
?>
<aside class="seller-sidebar">
    <h2>REDWOOD</h2>
    <p>SELLER CENTER</p>

    <nav class="seller-nav">
        <a class="seller-nav-item <?php echo $activeNav === 'dashboard' ? 'active' : ''; ?>"
           href="index.php?page=seller">
            <span class="nav-icon">▦</span> Dashboard
        </a>

        <div class="nav-group">
            <a class="seller-nav-item <?php echo in_array($activeNav, ['products','add-product']) ? 'active' : ''; ?>"
               href="index.php?page=seller-products">
                <span class="nav-icon">🏷</span> Products
            </a>
            <?php if (in_array($activeNav, ['products', 'add-product'])): ?>
                <a class="seller-subnav-item <?php echo $activeNav === 'products' ? 'active' : ''; ?>"
                   href="index.php?page=seller-products">All Products</a>
                <a class="seller-subnav-item <?php echo $activeNav === 'add-product' ? 'active' : ''; ?>"
                   href="index.php?page=seller-product-create">Add Product</a>
            <?php endif; ?>
        </div>

        <a class="seller-nav-item" href="#"><span class="nav-icon">📦</span> Inventory</a>

        <div class="nav-group">
            <a class="seller-nav-item <?php echo $activeNav === 'orders' ? 'active' : ''; ?>"
               href="index.php?page=seller-orders">
                <span class="nav-icon">🛍</span> Orders
            </a>
        </div>

        <a class="seller-nav-item" href="#"><span class="nav-icon">👤</span> Customers</a>
        <a class="seller-nav-item" href="#"><span class="nav-icon">📊</span> Analytics</a>
        <a class="seller-nav-item" href="#"><span class="nav-icon">🏬</span> Store</a>
        <a class="seller-nav-item" href="#"><span class="nav-icon">⚙</span> Settings</a>
    </nav>

    <div class="seller-sidebar-bottom">
        <a class="seller-nav-item" href="#">Help Center</a>
        <a class="seller-nav-item" href="index.php?page=logout">Logout</a>
    </div>
</aside>