<?php
$pageTitle = "Seller Products";
$activeNav = "products";
require "includes/header.php";
?>
<div class="seller-layout">
    <?php require "includes/seller-sidebar.php"; ?>
    <main class="seller-main">
        <?php require "includes/seller-topbar.php"; ?>
        <section class="seller-page-content">
            <div class="seller-page-heading">
                <div>
                    <h1>Products</h1>
                    <p>Manage all your products in one place.</p>
                </div>
                <a class="primary-button" href="index.php?page=seller-product-create">+ Add Product</a>
            </div>

            <?php
            // Fixed counting and filtering logic
            $statusCounts = ["all" => 0, "active" => 0, "draft" => 0, "out_of_stock" => 0];
            $productsArray = [];
            if ($products && $products->num_rows > 0) {
                while ($row = $products->fetch_assoc()) {
                    $productsArray[] = $row;
                    $statusCounts["all"]++;
                    if ((int)$row["stock_quantity"] === 0) {
                        $statusCounts["out_of_stock"]++;
                    } elseif (isset($statusCounts[$row["status"]])) {
                        $statusCounts[$row["status"]]++;
                    }
                }
            }
            $currentFilter = $_GET["status"] ?? "all";
            $filtered = array_filter($productsArray, function ($p) use ($currentFilter) {
                if ($currentFilter === "all") return true;
                if ($currentFilter === "out_of_stock") return (int)$p["stock_quantity"] === 0;
                return $p["status"] === $currentFilter;
            });
            ?>

            <div class="status-tabs">
                <?php foreach ($statusCounts as $key => $count): ?>
                    <a class="status-tab <?php echo $currentFilter === $key ? 'active' : ''; ?>"
                       href="index.php?page=seller-products&status=<?php echo $key; ?>">
                        <?php echo ucfirst($key === 'all' ? 'All Products' : str_replace('_', ' ', $key)); ?>
                        <span class="tab-count"><?php echo $count; ?></span>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="list-toolbar">
                <input type="text" class="search-input" placeholder="Search products..." id="productSearch">
                <button class="secondary-button" id="filterBtn">Filter</button>
                <button class="secondary-button" id="sortBtn">Sort</button>
            </div>

            <section class="seller-table-panel">
                <div class="table-wrapper">
                    <table class="seller-table" id="productTable">
                        <thead><tr>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr></thead>
                        <tbody>
                        <?php if (!empty($filtered)): ?>
                            <?php foreach ($filtered as $product): ?>
                                <tr>
                                    <td>
                                        <div class="table-product-cell">
                                            <div class="table-thumb" style="background-image: url('<?php echo htmlspecialchars($product["image_path"] ?? "assets/images/placeholder.jpg"); ?>'); background-size: cover;"></div>
                                            <div>
                                                <strong><?php echo htmlspecialchars($product["product_name"]); ?></strong>
                                                <br><small><?php echo htmlspecialchars($product["brand"] ?? ""); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($product["sku"]); ?></td>
                                    <td><?php echo htmlspecialchars($product["category_name"] ?? "General"); ?></td>
                                    <td>৳<?php echo number_format($product["price"], 2); ?></td>
                                    <td>
                                        <span class="<?php echo $product["stock_quantity"] <= $product["low_stock_threshold"] ? 'stock-low' : 'stock-good'; ?>">
                                            <?php echo (int)$product["stock_quantity"]; ?>
                                        </span>
                                    </td>
                                    <td><span class="status-badge"><?php echo htmlspecialchars($product["status"]); ?></span></td>
                                    <td>
                                        <a href="index.php?page=seller-product-edit&id=<?php echo $product["product_id"]; ?>">Edit</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="empty-table">No products found.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </section>
    </main>
</div>

<script>
document.getElementById('productSearch').addEventListener('keyup', function() {
    const search = this.value.toLowerCase();
    const rows = document.querySelectorAll('#productTable tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(search) ? '' : 'none';
    });
});
</script>
<?php require "includes/footer.php"; ?>