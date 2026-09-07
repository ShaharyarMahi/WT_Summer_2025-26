<?php

function requireLogin()
{
    if (!isset($_SESSION["user_id"])) {

        header("Location: index.php?page=login");

        exit;
    }
}
// Validate user login credentials

function requireRole($role)
{
    requireLogin();

    if ($_SESSION["role"] !== $role) {

        header("Location: index.php?page=home");

        exit;
    }
}

?>