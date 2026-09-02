<?php

$pageTitle = "Marketplace";

require "includes/header.php";
require "includes/navbar.php";

$categoryCounts = [];
$productsList = [];

if ($products && $products->num_rows > 0) {
    while ($product = $products->fetch_assoc()) {
        $productsList[] = $product;

        $categoryName = $product["category_name"] ?? "General";
        $categoryCounts[$categoryName] = ($categoryCounts[$categoryName] ?? 0) + 1;
    }
}

?>

<main class="catalog-page">
    <section class="catalog-toolbar">
        <div>
            <h1>Shop the Redwood Collection</h1>
        </div>
    </section>

    <section class="catalog-layout">
        <aside class="catalog-sidebar">
            <h3>Browse</h3>

            <div class="filter-group">
                <div class="filter-header">
                    <h4>Categories</h4>
                </div>

                <?php if (!empty($categoryCounts)): ?>
                    <?php foreach ($categoryCounts as $categoryName => $count): ?>
                        <?php $categoryValue = strtolower(str_replace(' ', '_', trim($categoryName))); ?>
                        <label class="filter-option">
                            <input type="checkbox" class="category-filter" value="<?php echo htmlspecialchars($categoryValue); ?>">
                            <span><?php echo htmlspecialchars($categoryName); ?></span>
                            <span class="filter-count">(<?php echo $count; ?>)</span>
                        </label>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-filter-items">No categories available.</p>
                <?php endif; ?>
            </div>

            <div class="filter-group">
                <div class="filter-header">
                    <h4>Price range</h4>
                </div>

                <div class="price-input-wrap">
                    <label for="maxPriceInput">Maximum price</label>
                    <div class="simple-price-input">
                        <span>BDT</span>
                        <input type="text" id="maxPriceInput" inputmode="numeric" pattern="[0-9]*" placeholder="Enter amount">
                    </div>
                    <button type="button" id="filterPriceBtn" class="filter-price-btn">Apply</button>
                </div>
            </div>
        </aside>

        <div class="catalog-panel">
            <?php if (!empty($productsList)): ?>
                <div class="product-grid" id="productGrid">
                    <?php foreach ($productsList as $product): ?>
                        <?php $categoryValue = strtolower(str_replace(' ', '_', trim($product["category_name"] ?? "General"))); ?>
                        <article class="product-card" data-price="<?php echo (float)$product["price"]; ?>" data-category="<?php echo htmlspecialchars($categoryValue); ?>">
                            <div class="product-thumb"></div>

                            <div class="product-body">
                                <div class="product-meta-line">
                                    <span class="meta-brand"><?php echo htmlspecialchars($product["brand"] ?? "Redwood"); ?></span>
                                    <span class="meta-category"><?php echo htmlspecialchars($product["category_name"] ?? "General"); ?></span>
                                </div>

                                <h3><?php echo htmlspecialchars($product["product_name"]); ?></h3>

                                <p class="product-desc">
                                    <?php echo htmlspecialchars($product["description"] ?? "Product description."); ?>
                                </p>

                                <div class="price-row">
                                    <span class="price">৳<?php echo number_format((float)$product["price"], 2); ?></span>
                                </div>

                                <div class="cta-row-product">
                                    <a class="btn-primary-small" href="index.php?page=product&id=<?php echo $product["product_id"]; ?>">View</a>

                                    <form method="POST" action="index.php?page=add-to-cart" class="inline-form">
                                        <input type="hidden" name="product_id" value="<?php echo (int)$product["product_id"]; ?>">
                                        <input type="hidden" name="redirect" value="products">
                                        <button type="submit" class="cart-btn" aria-label="Add to cart">Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <h3>No products are available right now.</h3>
                    <p>Please check back later for new arrivals.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categoryCheckboxes = document.querySelectorAll('.category-filter');
        const cards = document.querySelectorAll('.product-card');
        const grid = document.getElementById('productGrid');
        const maxPriceInput = document.getElementById('maxPriceInput');
        const filterPriceBtn = document.getElementById('filterPriceBtn');

        function applyFilters() {
            const selectedCategories = Array.from(categoryCheckboxes)
                .filter(input => input.checked)
                .map(input => input.value);

            const enteredValue = maxPriceInput.value.trim();
            const maxPrice = enteredValue === '' ? null : Number(enteredValue);

            let visibleCount = 0;

            cards.forEach(function (card) {
                const price = Number(card.dataset.price || 0);
                const category = String(card.dataset.category || '').toLowerCase();
                let shouldShow = true;

                if (selectedCategories.length > 0) {
                    shouldShow = selectedCategories.includes(category);
                }

                if (shouldShow && maxPrice !== null && !isNaN(maxPrice)) {
                    shouldShow = price <= maxPrice;
                }

                card.style.display = shouldShow ? '' : 'none';
                if (shouldShow) visibleCount++;
            });

            const noMatch = document.getElementById('noPriceMatch');
            if (noMatch) {
                noMatch.remove();
            }

            if (visibleCount === 0 && (selectedCategories.length > 0 || maxPrice !== null)) {
                const message = document.createElement('div');
                message.id = 'noPriceMatch';
                message.className = 'empty-state';
                message.innerHTML = '<h3>No products match this filter.</h3><p>Please try another category or maximum price.</p>';
                grid.parentNode.appendChild(message);
            }
        }

        categoryCheckboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', applyFilters);
        });

        if (filterPriceBtn) {
            filterPriceBtn.addEventListener('click', applyFilters);
        }

        if (maxPriceInput) {
            maxPriceInput.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    applyFilters();
                }
            });
        }
    });
</script>

<?php

require "includes/footer.php";

?>