<?php
$pageTitle = "Add Product";
$activeNav = "add-product";
require "includes/header.php";
?>
<div class="seller-layout">
    <?php require "includes/seller-sidebar.php"; ?>
    <main class="seller-main">
        <?php require "includes/seller-topbar.php"; ?>
        <section class="seller-page-content">
            <a class="back-link" href="index.php?page=seller-products">← Back to Products</a>
            <h1>Add New Product</h1>
            <p class="page-description">Add a new product to your store and start selling.</p>

            <form method="POST" action="index.php?page=seller-product-store" class="product-form" enctype="multipart/form-data">
                <div class="product-form-layout">
                    <!-- Main form fields -->
                    <div class="form-section">
                        <h2>Product Information</h2>
                        <div class="form-grid">
                            <div class="form-group">
                                <label>Product Name *</label>
                                <input type="text" name="product_name" required>
                            </div>
                            <div class="form-group">
                                <label>SKU *</label>
                                <input type="text" name="sku" required>
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category_id" required>
                                    <option value="">Select category</option>
                                    <?php while ($cat = $categories->fetch_assoc()): ?>
                                        <option value="<?php echo (int)$cat['category_id']; ?>">
                                            <?php echo htmlspecialchars($cat['category_name']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Brand</label>
                                <input type="text" name="brand">
                            </div>
                            <div class="form-group form-full">
                                <label>Description *</label>
                                <textarea name="description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Price *</label>
                                <input type="number" name="price" min="0.01" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label>Compare Price</label>
                                <input type="number" name="compare_price" min="0" step="0.01">
                            </div>
                            <div class="form-group">
                                <label>Stock Quantity *</label>
                                <input type="number" name="stock_quantity" min="0" required>
                            </div>
                            <div class="form-group">
                                <label>Low Stock Alert</label>
                                <input type="number" name="low_stock_threshold" min="0" value="5">
                            </div>
                            <!-- Status dropdown removed – now controlled by sidebar radios -->
                        </div>
                    </div>

                    <!-- Sidebar panels -->
                    <div class="form-sidebar">
                        <div class="form-sidebar-panel">
                            <h3>Product Status</h3>
                            <div class="radio-option">
                                <input type="radio" name="status" value="active" checked> Active
                                <span>Product will be visible to customers</span>
                            </div>
                            <div class="radio-option">
                                <input type="radio" name="status" value="draft"> Draft
                                <span>Save as draft and publish later</span>
                            </div>
                        </div>
                        <div class="form-sidebar-panel">
                            <h3>Shipping Information</h3>
                            <div class="form-group">
                                <label>Weight (kg)</label>
                                <input type="number" name="weight" step="0.01" placeholder="0.00">
                            </div>
                            <div class="form-group">
                                <label>Dimensions (cm)</label>
                                <div style="display:flex; gap:6px;">
                                    <input type="number" name="length" placeholder="L">
                                    <input type="number" name="width" placeholder="W">
                                    <input type="number" name="height" placeholder="H">
                                </div>
                            </div>
                        </div>
                        <div class="form-sidebar-panel">
                            <h3>Product Visibility</h3>
                            <div class="check-option">
                                <input type="checkbox" name="visible_on_store" checked> Visible on store
                                <span>Product will be visible to all customers</span>
                            </div>
                            <div class="check-option">
                                <input type="checkbox" name="featured"> Featured Product
                                <span>Showcase this product on homepage</span>
                            </div>
                            <div class="check-option">
                                <input type="checkbox" name="allow_preorder"> Allow Pre-order
                                <span>Allow customers to pre-order this product</span>
                            </div>
                        </div>
                        <div class="form-sidebar-panel">
                            <h3>Product Images</h3>
                            <p>Upload clear images of your product. You can upload up to 8 images.</p>
                            <div style="border:2px dashed #d1d5db; border-radius:8px; padding:20px; text-align:center; cursor:pointer;" onclick="document.getElementById('imageUpload').click();">
                                Click to upload or drag and drop<br>
                                <small>PNG, JPG, JPEG up to 5MB each</small>
                                <input type="file" id="imageUpload" name="product_images[]" multiple accept="image/*" style="display:none;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="index.php?page=seller-products" class="secondary-button">Cancel</a>
                    <button type="submit" class="primary-button">Publish Product</button>
                </div>
            </form>
        </section>
    </main>
</div>
<?php require "includes/footer.php"; ?>