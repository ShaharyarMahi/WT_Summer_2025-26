<?php

$pageTitle = "Create Account";

require "includes/header.php";
require "includes/navbar.php";

?>

<main class="register-page">
    <div class="register-shell">
        <aside class="register-copy">
            <h1>Create Your<br>Account</h1>
            <div class="register-line"></div>
            <p>Join Redwood Marketplace and enjoy a better way to shop online.</p>
        </aside>

        <section class="register-card">
            <?php if (!empty($error)): ?>
                <p class="error-text"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <p class="success-text"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>

            <form method="POST" action="index.php?page=register" class="register-form">
                <div class="field-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>
                </div>

                <div class="field-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" placeholder="Enter your last name" required>
                </div>

                <div class="field-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                </div>

                <div class="field-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" placeholder="Enter your phone number">
                </div>

                <div class="field-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a password" required>
                </div>

                <button type="submit" class="btn btn-primary">Create Account</button>
            </form>

            <p class="register-meta">Already have an account? <a href="index.php?page=login">Sign In</a></p>
        </section>
    </div>
</main>

<?php

require "includes/footer.php";

?>