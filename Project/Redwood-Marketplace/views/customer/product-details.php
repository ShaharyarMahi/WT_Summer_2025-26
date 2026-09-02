<?php

$pageTitle = $product["product_name"];

require "includes/header.php";
require "includes/navbar.php";

?>

<main class="detail-page">

    <p class="back-link-row">
        <a href="index.php?page=products">
            ← Back to products
        </a>
    </p>


    <section class="detail-shell">


        <!-- LEFT SIDE -->

        <div class="detail-info">

            <p class="eyebrow">
                Redwood Marketplace
            </p>


            <h1>
                <?php echo htmlspecialchars(
                    $product["product_name"]
                ); ?>
            </h1>


            <div class="detail-meta-row">

                <span class="stars">
                    ★★★★★
                </span>

                <span>
                    4.8 rating
                </span>

                <span>•</span>

                <span>
                    <?php echo htmlspecialchars(
                        $product["brand"] ?? "Redwood"
                    ); ?>
                </span>

                <span>•</span>

                <span>
                    <?php echo htmlspecialchars(
                        $product["category_name"] ?? "General"
                    ); ?>
                </span>

            </div>


            <!-- PRICE -->

            <div class="pricing-block">

                <span class="price">
                    BDT
                    <?php echo number_format(
                        (float)$product["price"],
                        2
                    ); ?>
                </span>

            </div>


            <!-- DESCRIPTION -->

            <p class="description-text">

                <?php echo htmlspecialchars(
                    $product["description"]
                    ?? "No description available."
                ); ?>

            </p>


            <!-- FEATURES -->

            <ul class="feature-list">

                <li>
                    Premium quality materials
                </li>

                <li>
                    Fast delivery across the country
                </li>

                <li>
                    Secure checkout and easy returns
                </li>

            </ul>


            <!-- QUANTITY -->

            <div class="quantity-section">

                <label>
                    Quantity
                </label>

                <div class="quantity-box">

                    <button type="button">
                        −
                    </button>

                    <span>
                        1
                    </span>

                    <button type="button">
                        +
                    </button>

                </div>

            </div>


            <!-- BUTTONS -->

            <div class="detail-actions">


                <form
                    method="POST"
                    action="index.php?page=add-to-cart"
                >

                    <input
                        type="hidden"
                        name="product_id"
                        value="<?php echo (int)$product["product_id"]; ?>"
                    >

                    <input
                        type="hidden"
                        name="redirect"
                        value="product&id=<?php echo (int)$product["product_id"]; ?>"
                    >

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Add to Cart
                    </button>

                </form>


                <form
                    method="POST"
                    action="index.php?page=toggle-wishlist"
                >

                    <input
                        type="hidden"
                        name="product_id"
                        value="<?php echo (int)$product["product_id"]; ?>"
                    >

                    <input
                        type="hidden"
                        name="redirect"
                        value="product&id=<?php echo (int)$product["product_id"]; ?>"
                    >

                    <button
                        type="submit"
                        class="btn btn-outline"
                    >

                        <?php

                        echo isset(
                            $wishlistIds[
                                $product["product_id"]
                            ]
                        )
                            ? "Remove from Wishlist"
                            : "Add to Wishlist";

                        ?>

                    </button>

                </form>


            </div>

        </div>


        <!-- RIGHT SIDE -->

        <div class="product-basic-details">

            <h2>
                Product Details
            </h2>


            <div class="detail-row">

                <span>
                    Product Name
                </span>

                <strong>
                    <?php echo htmlspecialchars(
                        $product["product_name"]
                    ); ?>
                </strong>

            </div>


            <div class="detail-row">

                <span>
                    Brand
                </span>

                <strong>
                    <?php echo htmlspecialchars(
                        $product["brand"] ?? "Redwood"
                    ); ?>
                </strong>

            </div>


            <div class="detail-row">

                <span>
                    Category
                </span>

                <strong>
                    <?php echo htmlspecialchars(
                        $product["category_name"]
                        ?? "General"
                    ); ?>
                </strong>

            </div>


            <div class="detail-row">

                <span>
                    SKU
                </span>

                <strong>
                    <?php echo htmlspecialchars(
                        $product["sku"] ?? "N/A"
                    ); ?>
                </strong>

            </div>


            <div class="detail-row">

                <span>
                    Stock
                </span>

                <strong>
                    <?php echo (int)(
                        $product["stock_quantity"]
                        ?? 0
                    ); ?>
                </strong>

            </div>


            <div class="detail-row">

                <span>
                    Status
                </span>

                <strong>
                    <?php echo htmlspecialchars(
                        $product["status"] ?? "Available"
                    ); ?>
                </strong>

            </div>


            <hr>


            <h3>
                Description
            </h3>


            <p>
                <?php echo htmlspecialchars(
                    $product["description"]
                    ?? "No description available."
                ); ?>
            </p>

        </div>


    </section>

</main>


<?php

require "includes/footer.php";

?>