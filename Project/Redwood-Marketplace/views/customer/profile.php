<?php

$pageTitle = "My Profile";

require "includes/header.php";
require "includes/navbar.php";

?>

<main>

    <h1>My Profile</h1>

    <hr>

    <h2>Personal Information</h2>

    <p>
        <strong>First Name:</strong>

        <?php echo htmlspecialchars(
            $user["first_name"]
        ); ?>
    </p>


    <p>
        <strong>Last Name:</strong>

        <?php echo htmlspecialchars(
            $user["last_name"] ?? ""
        ); ?>
    </p>


    <p>
        <strong>Email:</strong>

        <?php echo htmlspecialchars(
            $user["email"]
        ); ?>
    </p>


    <p>
        <strong>Phone:</strong>

        <?php echo htmlspecialchars(
            $user["phone"] ?? ""
        ); ?>
    </p>


    <hr>


    <h2>Account Information</h2>

    <p>
        <strong>Role:</strong>

        <?php echo htmlspecialchars(
            $user["role"]
        ); ?>
    </p>


    <p>
        <strong>Status:</strong>

        <?php echo htmlspecialchars(
            $user["status"]
        ); ?>
    </p>


    <p>
        <strong>Member Since:</strong>

        <?php echo htmlspecialchars(
            $user["created_at"]
        ); ?>
    </p>


    <hr>


    <p>

        <a href="index.php?page=profile-edit">
            Edit Profile
        </a>

    </p>


    <p>

        <a href="index.php?page=orders">
            My Orders
        </a>

    </p>


    <p>

        <a href="index.php?page=addresses">
            My Addresses
        </a>

    </p>


    <p>

        <a href="index.php?page=customer">
            ← Back to Dashboard
        </a>

    </p>

</main>

<?php

require "includes/footer.php";

?>