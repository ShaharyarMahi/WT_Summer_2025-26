<?php

$pageTitle = "My Addresses";

require "includes/header.php";
require "includes/navbar.php";

?>

<main>

    <h1>My Addresses</h1>


    <p>

        <a href="index.php?page=address-create">
            + Add New Address
        </a>

    </p>


    <?php if ($addresses->num_rows === 0): ?>

        <p>
            You don't have any saved addresses.
        </p>


    <?php else: ?>


        <?php while (
            $address = $addresses->fetch_assoc()
        ): ?>

            <section>

                <h2>

                    <?php echo htmlspecialchars(
                        $address["address_type"]
                    ); ?>


                    <?php if (
                        $address["is_default"]
                    ): ?>

                        <strong>
                            — Default
                        </strong>

                    <?php endif; ?>

                </h2>


                <p>

                    <strong>

                        <?php echo htmlspecialchars(
                            $address["full_name"]
                        ); ?>

                    </strong>

                    <br>

                    <?php echo htmlspecialchars(
                        $address["phone"]
                    ); ?>

                    <br>

                    <?php echo htmlspecialchars(
                        $address["address_line"]
                    ); ?>

                    <br>

                    <?php echo htmlspecialchars(
                        $address["city"]
                    ); ?>

                    <?php if (
                        !empty(
                            $address["postal_code"]
                        )
                    ): ?>

                        -
                        <?php echo htmlspecialchars(
                            $address["postal_code"]
                        ); ?>

                    <?php endif; ?>

                    <br>

                    <?php echo htmlspecialchars(
                        $address["country"]
                    ); ?>

                </p>


                <p>

                    <a href="index.php?page=address-edit&id=<?php
                        echo (int)$address["address_id"];
                    ?>">
                        Edit
                    </a>


                    <?php if (
                        !$address["is_default"]
                    ): ?>

                        |

                        <a href="index.php?page=address-default&id=<?php
                            echo (int)$address["address_id"];
                        ?>">
                            Set as Default
                        </a>

                        |

                        <a
                            href="index.php?page=address-delete&id=<?php
                                echo (int)$address["address_id"];
                            ?>"
                            onclick="return confirm(
                                'Are you sure you want to delete this address?'
                            );"
                        >
                            Delete
                        </a>

                    <?php endif; ?>

                </p>

            </section>

            <hr>

        <?php endwhile; ?>


    <?php endif; ?>

</main>

<?php

require "includes/footer.php";

?>