<?php

$pageTitle = "Edit Profile";

require "includes/header.php";
require "includes/navbar.php";

?>

<main>

    <h1>Edit Profile</h1>

    <hr>

    <form
        method="POST"
        action="index.php?page=profile-update"
    >

        <div>

            <label for="first_name">
                First Name
            </label>

            <br>

            <input
                type="text"
                id="first_name"
                name="first_name"
                value="<?php echo htmlspecialchars(
                    $user["first_name"]
                ); ?>"
                required
            >

        </div>

        <br>


        <div>

            <label for="last_name">
                Last Name
            </label>

            <br>

            <input
                type="text"
                id="last_name"
                name="last_name"
                value="<?php echo htmlspecialchars(
                    $user["last_name"] ?? ""
                ); ?>"
            >

        </div>

        <br>


        <div>

            <label for="email">
                Email
            </label>

            <br>

            <input
                type="email"
                id="email"
                name="email"
                value="<?php echo htmlspecialchars(
                    $user["email"]
                ); ?>"
                required
            >

        </div>

        <br>


        <div>

            <label for="phone">
                Phone
            </label>

            <br>

            <input
                type="text"
                id="phone"
                name="phone"
                value="<?php echo htmlspecialchars(
                    $user["phone"] ?? ""
                ); ?>"
            >

        </div>

        <br>


        <button type="submit">
            Update Profile
        </button>

    </form>

    <br>

    <a href="index.php?page=profile">
        Cancel
    </a>

</main>

<?php

require "includes/footer.php";

?>