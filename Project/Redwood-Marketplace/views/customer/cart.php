<?php

$pageTitle = "Your Cart";

require "includes/header.php";
require "includes/navbar.php";

?>

<main class="cart-page">
    <section class="catalog-toolbar">
        <div>
            <p class="eyebrow">Your bag</p>
            <h1>Shopping Cart</h1>
        </div>
    </section>

    <?php if (empty($cartItems)): ?>
        <div class="empty-state">
            <h3>Your cart is empty.</h3>
            <p>Add your favorite forest essentials to get started.</p>
            <a class="btn btn-outline" href="index.php?page=products">Continue Shopping</a>
        </div>
    <?php else: ?>
        <?php
        $subtotal = 0;
        if (is_array($cartItems) && !empty($cartItems)) {
            foreach ($cartItems as $item) {
                $subtotal += (float)$item["price"] * (int)$item["quantity"];
            }
        }
        ?>

        <div class="cart-layout">
            <div class="cart-list">
                <?php if (is_array($cartItems) && !empty($cartItems)): ?>
                    <?php foreach ($cartItems as $item): ?>
                        <?php $itemTotal = (float)$item["price"] * (int)$item["quantity"]; ?>
                        <article class="cart-item">
                            <div class="cart-thumb"></div>
                            <div class="cart-info">
                                <h2><?php echo htmlspecialchars($item["product_name"]); ?></h2>
                                <p class="cart-meta">Brand: <?php echo htmlspecialchars($item["brand"] ?? "N/A"); ?></p>
                                <p class="cart-price">৳<?php echo number_format((float)$item["price"], 2); ?></p>
                            </div>

                            <div class="cart-actions">
                                <div class="quantity-box">
                                    <form method="POST" action="index.php?page=update-cart">
                                        <input type="hidden" name="cart_item_id" value="<?php echo (int)$item["cart_item_id"]; ?>">
                                        <button type="submit" name="quantity" value="<?php echo max(1, (int)$item["quantity"] - 1); ?>">−</button>
                                        <strong><?php echo (int)$item["quantity"]; ?></strong>
                                        <button type="submit" name="quantity" value="<?php echo (int)$item["quantity"] + 1; ?>">+</button>
                                    </form>
                                </div>

                                <form method="POST" action="index.php?page=remove-from-cart" class="inline-form">
                                    <input type="hidden" name="cart_item_id" value="<?php echo (int)$item["cart_item_id"]; ?>">
                                    <button type="submit" class="remove-btn">Remove</button>
                                </form>
                            </div>

                            <div class="cart-total-box">
                                <span>Item total</span>
                                <strong>৳<?php echo number_format($itemTotal, 2); ?></strong>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php while ($item = $cartItems->fetch_assoc()): ?>
                        <?php $itemTotal = (float)$item["price"] * (int)$item["quantity"]; $subtotal += $itemTotal; ?>
                        <article class="cart-item">
                            <div class="cart-thumb"></div>
                            <div class="cart-info">
                                <h2><?php echo htmlspecialchars($item["product_name"]); ?></h2>
                                <p class="cart-meta">Brand: <?php echo htmlspecialchars($item["brand"] ?? "N/A"); ?></p>
                                <p class="cart-price">৳<?php echo number_format((float)$item["price"], 2); ?></p>
                            </div>

                            <div class="cart-actions">
                                <div class="quantity-box">
                                    <form method="POST" action="index.php?page=update-cart">
                                        <input type="hidden" name="cart_item_id" value="<?php echo (int)$item["cart_item_id"]; ?>">
                                        <button type="submit" name="quantity" value="<?php echo max(1, (int)$item["quantity"] - 1); ?>">−</button>
                                        <strong><?php echo (int)$item["quantity"]; ?></strong>
                                        <button type="submit" name="quantity" value="<?php echo (int)$item["quantity"] + 1; ?>">+</button>
                                    </form>
                                </div>

                                <form method="POST" action="index.php?page=remove-from-cart" class="inline-form">
                                    <input type="hidden" name="cart_item_id" value="<?php echo (int)$item["cart_item_id"]; ?>">
                                    <button type="submit" class="remove-btn">Remove</button>
                                </form>
                            </div>

                            <div class="cart-total-box">
                                <span>Item total</span>
                                <strong>৳<?php echo number_format($itemTotal, 2); ?></strong>
                            </div>
                        </article>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>

            <aside class="cart-summary-box">
                <h2>Order Summary</h2>
                <div class="summary-row"><span>Subtotal</span><strong>৳<?php echo number_format($subtotal, 2); ?></strong></div>
                <div class="summary-row"><span>Shipping</span><strong>৳0.00</strong></div>
                <div class="summary-row"><span>Tax</span><strong>৳0.00</strong></div>
                <div class="summary-total"><span>Total</span><strong>৳<?php echo number_format($subtotal, 2); ?></strong></div>
                <a href="index.php?page=checkout" class="btn btn-primary">Proceed to Checkout</a>
                <a href="index.php?page=products" class="btn btn-outline">Continue Shopping</a>
            </aside>
        </div>
    <?php endif; ?>
</main>

<?php require "includes/footer.php"; ?>