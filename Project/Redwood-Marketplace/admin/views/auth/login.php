<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - E-commerce Management System</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>

    <div class="login-wrapper">
        <div class="login-box">
            <h2>Admin Login</h2>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="index.php?page=login" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-full">Login</button>
            </form>
        </div>
    </div>

</body>
</html>
