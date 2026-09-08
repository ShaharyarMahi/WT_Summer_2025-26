<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - E-commerce Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="admin-wrapper">
    <?php require __DIR__ . '/sidebar.php'; ?>

    <div class="main-content">
        <div class="topbar">
            <div><strong>E-commerce Admin Panel</strong></div>
            <div class="admin-info">
                Logged in as <strong><?= htmlspecialchars($_SESSION['admin_name'] ?? '') ?></strong>
                &nbsp;|&nbsp;
                <a href="index.php?page=logout" class="btn btn-danger" style="padding:6px 12px;">Logout</a>
            </div>
        </div>
