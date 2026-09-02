<?php

$pageTitle = "Wishlist";

require "includes/header.php";
require "includes/navbar.php";

?>

<main>
    <section class="catalog-toolbar">
        <div>
            <p class="eyebrow">Saved items</p>
            <h1>Your Wishlist</h1>
        </div>
    </section>

    <?php if (empty($wishlistItems)): ?>
        <div class="empty-state">
            <h3>Your wishlist is empty.</h3>
            <p>Save products you love and check them again later.</p>
            <a class="btn btn-outline" href="index.php?page=products">Browse Products</a>
        </div>
    <?php else: ?>
        <div class="product-grid">
            <?php foreach ($wishlistItems as $product): ?>
                <article class="product-card">
                    <div class="product-thumb">
                        <span class="product-tag">Saved</span>
                        <span class="product-badge">Wishlist</span>
                    </div>

                    <div class="product-body">
                        <div class="product-meta-line">
                            <span class="meta-brand"><?php echo htmlspecialchars($product["brand"] ?? "Redwood"); ?></span>
                            <span class="meta-category"><?php echo htmlspecialchars($product["category_name"] ?? "General"); ?></span>
                        </div>

                        <h3><?php echo htmlspecialchars($product["product_name"]); ?></h3>

                        <div class="price-row">
                            <span class="price">৳<?php echo number_format((float)$product["price"], 2); ?></span>
                        </div>

                        <div class="cta-row-product">
                            <a class="btn-primary-small" href="index.php?page=product&id=<?php echo (int)$product["product_id"]; ?>">View Product</a>

                            <form method="POST" action="index.php?page=toggle-wishlist" class="inline-form">
                                <input type="hidden" name="product_id" value="<?php echo (int)$product["product_id"]; ?>">
                                <input type="hidden" name="redirect" value="wishlist">
                                <button type="submit" class="wishlist-btn" aria-label="Remove from wishlist">♥</button>
                            </form>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php
require "includes/footer.php";
?>
