<?php

$isEdit =
    isset($address) && $address !== false;

$pageTitle =
    $isEdit
        ? "Edit Address"
        : "Add Address";

require "includes/header.php";
require "includes/navbar.php";

?>


<main>

    <h1>

        <?php echo $isEdit
            ? "Edit Address"
            : "Add New Address";
        ?>

    </h1>


    <form
        method="POST"
        action="index.php?page=<?php
            echo $isEdit
                ? "address-update"
                : "address-store";
        ?>"
    >


        <?php if ($isEdit): ?>

            <input
                type="hidden"
                name="address_id"
                value="<?php echo
                    (int)$address["address_id"];
                ?>"
            >

        <?php endif; ?>


        <!-- Address Type -->

        <label>
            Address Type
        </label>

        <br>

        <select name="address_type">

            <option
                value="home"
                <?php
                if (
                    $isEdit
                    && $address["address_type"]
                        === "home"
                ) {
                    echo "selected";
                }
                ?>
            >
                Home
            </option>

            <option
                value="office"
                <?php
                if (
                    $isEdit
                    && $address["address_type"]
                        === "office"
                ) {
                    echo "selected";
                }
                ?>
            >
                Office
            </option>

            <option
                value="other"
                <?php
                if (
                    $isEdit
                    && $address["address_type"]
                        === "other"
                ) {
                    echo "selected";
                }
                ?>
            >
                Other
            </option>

        </select>


        <br><br>


        <!-- Full Name -->

        <label>
            Full Name *
        </label>

        <br>

        <input
            type="text"
            name="full_name"
            required
            value="<?php echo $isEdit
                ? htmlspecialchars(
                    $address["full_name"]
                )
                : "";
            ?>"
        >


        <br><br>


        <!-- Phone -->

        <label>
            Phone *
        </label>

        <br>

        <input
            type="text"
            name="phone"
            required
            value="<?php echo $isEdit
                ? htmlspecialchars(
                    $address["phone"] ?? ""
                )
                : "";
            ?>"
        >


        <br><br>


        <!-- Address -->

        <label>
            Address *
        </label>

        <br>

        <textarea
            name="address_line"
            required
        ><?php echo $isEdit
            ? htmlspecialchars(
                $address["address_line"]
            )
            : "";
        ?></textarea>


        <br><br>


        <!-- City -->

        <label>
            City *
        </label>

        <br>

        <input
            type="text"
            name="city"
            required
            value="<?php echo $isEdit
                ? htmlspecialchars(
                    $address["city"]
                )
                : "";
            ?>"
        >


        <br><br>


        <!-- Postal Code -->

        <label>
            Postal Code
        </label>

        <br>

        <input
            type="text"
            name="postal_code"
            value="<?php echo $isEdit
                ? htmlspecialchars(
                    $address["postal_code"] ?? ""
                )
                : "";
            ?>"
        >


        <br><br>


        <!-- Country -->

        <label>
            Country
        </label>

        <br>

        <input
            type="text"
            name="country"
            value="<?php echo $isEdit
                ? htmlspecialchars(
                    $address["country"]
                )
                : "Bangladesh";
            ?>"
        >


        <br><br>


        <!-- Default -->

        <label>

            <input
                type="checkbox"
                name="is_default"
                value="1"
                <?php
                if (
                    $isEdit
                    && $address["is_default"]
                ) {
                    echo "checked";
                }
                ?>
            >

            Set as default address

        </label>


        <br><br>


        <button type="submit">

            <?php echo $isEdit
                ? "Update Address"
                : "Save Address";
            ?>

        </button>


    </form>


    <br>


    <a href="index.php?page=addresses">

        ← Back to My Addresses

    </a>

</main>


<?php

require "includes/footer.php";

?>