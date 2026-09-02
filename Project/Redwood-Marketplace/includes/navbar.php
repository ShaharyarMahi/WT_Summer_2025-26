<nav class="main-nav">
    <div class="brand-wrap">
        <a href="index.php" class="brand-home-link">
            <div class="brand-text">
                <span class="brand-name">REDWOOD</span>
                <span class="brand-sub">MARKETPLACE</span>
            </div>
        </a>
    </div>

    <div class="nav-links">
        <a href="index.php">Browse Products</a>
        <a href="index.php?page=products">Deals</a>
        <a href="index.php?page=products">New Arrivals</a>
        <a href="index.php?page=products">Brands</a>
    </div>

    <div class="nav-tools">
        <div class="search-box">
            <input type="text" placeholder="Search for products, brands and more...">
            <button aria-label="Search">Search</button>
        </div>

        <a href="index.php?page=wishlist" class="nav-action">Wishlist</a>
        <a href="index.php?page=cart" class="nav-action">Cart</a>
        <a href="<?php echo isset($_SESSION["user_id"]) ? "index.php?page=customer" : "index.php?page=login"; ?>" class="nav-action">
            <?php echo isset($_SESSION["user_id"]) ? "My Account" : "My Account"; ?>
        </a>
    </div>
</nav>