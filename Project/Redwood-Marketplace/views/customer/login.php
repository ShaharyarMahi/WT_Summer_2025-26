<?php

$pageTitle = "Login";

require "includes/header.php";
require "includes/navbar.php";

?>

<main class="login-page">
    <div class="auth-shell">
        <aside class="auth-copy">
            <p class="eyebrow">Welcome back!</p>
            <h1>Sign in</h1>
            <p class="auth-subtitle">Please enter your details to continue</p>
        </aside>

        <section class="auth-card login-card">
            <?php if (!empty($error)): ?>
                <p class="error-text"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <form method="POST" action="index.php?page=login" class="login-form">
                <div class="input-group">
                    <label for="email">Email address</label>
                    <input type="email" id="email" name="email" placeholder="you@example.com" required>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <div class="row-inline">
                    <label class="checkbox-line">
                        <input type="checkbox" name="remember" value="1">
                        <span>Remember me</span>
                    </label>
                    <a href="#">Forgot password?</a>
                </div>

                <button type="submit" class="btn btn-primary">Sign in</button>
            </form>

            <div class="or-divider"><span>or</span></div>

            <p class="login-meta">
                Don't have an account? <a href="index.php?page=register">Create account</a>
            </p>
        </section>
    </div>
</main>

<?php require "includes/footer.php"; ?>