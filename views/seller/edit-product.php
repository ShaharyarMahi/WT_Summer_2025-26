<?php
$pageTitle = "Edit Product";
$activeNav = "products";
require "includes/header.php";
?>
<div class="seller-layout">
    <?php require "includes/seller-sidebar.php"; ?>
    <main class="seller-main">
        <?php require "includes/seller-topbar.php"; ?>
        <section class="seller-page-content">
            <a class="back-link" href="index.php?page=seller-products">← Back to Products</a>
            <h1>Edit Product</h1>

            <form method="POST" action="index.php?page=seller-product-update" class="product-form" enctype="multipart/form-data">
                <input type="hidden" name="product_id" value="<?php echo (int)$product["product_id"]; ?>">
                <div class="product-form-layout">
                    <div class="form-section">
                        <h2>Product Information</h2>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Product Name *</label>
                                <input type="text" name="product_name" value="<?php echo htmlspecialchars($product["product_name"]); ?>" required>
                            </div>
                            <div class="form-group">
                                <label>SKU *</label>
                                <input type="text" name="sku" value="<?php echo htmlspecialchars($product["sku"]); ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category_id" required>
                                    <?php while ($cat = $categories->fetch_assoc()): ?>
                                        <option value="<?php echo (int)$cat['category_id']; ?>"
                                            <?php echo ($cat['category_id'] == $product['category_id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat['category_name']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Brand</label>
                                <input type="text" name="brand" value="<?php echo htmlspecialchars($product["brand"] ?? ""); ?>">
                            </div>
                            <div class="form-group form-full">
                                <label>Description *</label>
                                <textarea name="description" required><?php echo htmlspecialchars($product["description"]); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Price *</label>
                                <input type="number" name="price" min="0.01" step="0.01" value="<?php echo $product["price"]; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Compare Price</label>
                                <input type="number" name="compare_price" min="0" step="0.01" value="<?php echo $product["compare_price"] ?? ""; ?>">
                            </div>
                            <div class="form-group">
                                <label>Stock Quantity *</label>
                                <input type="number" name="stock_quantity" min="0" value="<?php echo (int)$product["stock_quantity"]; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Low Stock Alert</label>
                                <input type="number" name="low_stock_threshold" min="0" value="<?php echo (int)$product["low_stock_threshold"]; ?>">
                            </div>
                            <!-- Status dropdown removed – now controlled by sidebar radios -->
                        </div>
                    </div>

                    <div class="form-sidebar">
                        <div class="form-sidebar-panel">
                            <h3>Product Status</h3>
                            <div class="radio-option">
                                <input type="radio" name="status" value="active" <?php echo $product["status"] === "active" ? "checked" : ""; ?>> Active
                                <span>Product will be visible to customers</span>
                            </div>
                            <div class="radio-option">
                                <input type="radio" name="status" value="draft" <?php echo $product["status"] === "draft" ? "checked" : ""; ?>> Draft
                                <span>Save as draft and publish later</span>
                            </div>
                        </div>
                        <div class="form-sidebar-panel">
                            <h3>Shipping Information</h3>
                            <div class="form-group">
                                <label>Weight (kg)</label>
                                <input type="number" name="weight" step="0.01" placeholder="0.00" value="<?php echo $product["weight"] ?? ""; ?>">
                            </div>
                            <div class="form-group">
                                <label>Dimensions (cm)</label>
                                <div style="display:flex; gap:6px;">
                                    <input type="number" name="length" placeholder="L" value="<?php echo $product["length_cm"] ?? ""; ?>">
                                    <input type="number" name="width" placeholder="W" value="<?php echo $product["width_cm"] ?? ""; ?>">
                                    <input type="number" name="height" placeholder="H" value="<?php echo $product["height_cm"] ?? ""; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-sidebar-panel">
                            <h3>Product Visibility</h3>
                            <div class="check-option">
                                <input type="checkbox" name="visible_on_store" <?php echo isset($product["is_visible"]) && $product["is_visible"] ? "checked" : "checked"; ?>> Visible on store
                                <span>Product will be visible to all customers</span>
                            </div>
                            <div class="check-option">
                                <input type="checkbox" name="featured" <?php echo isset($product["is_featured"]) && $product["is_featured"] ? "checked" : ""; ?>> Featured Product
                                <span>Showcase this product on homepage</span>
                            </div>
                            <div class="check-option">
                                <input type="checkbox" name="allow_preorder" <?php echo isset($product["allow_preorder"]) && $product["allow_preorder"] ? "checked" : ""; ?>> Allow Pre-order
                                <span>Allow customers to pre-order this product</span>
                            </div>
                        </div>
                        <div class="form-sidebar-panel">
                            <h3>Product Images</h3>
                            <p>Upload clear images of your product. You can upload up to 8 images.</p>
                            <div style="border:2px dashed #d1d5db; border-radius:8px; padding:20px; text-align:center; cursor:pointer;" onclick="document.getElementById('imageUploadEdit').click();">
                                Click to upload or drag and drop<br>
                                <small>PNG, JPG, JPEG up to 5MB each</small>
                                <input type="file" id="imageUploadEdit" name="product_images[]" multiple accept="image/*" style="display:none;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="index.php?page=seller-products" class="secondary-button">Cancel</a>
                    <button type="submit" class="primary-button">Save Changes</button>
                </div>
            </form>
        </section>
    </main>
</div>
<?php require "includes/footer.php"; ?>