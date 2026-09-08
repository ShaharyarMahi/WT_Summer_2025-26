<?php

/**
 * Admin login গার্ড।
 * $_SESSION['admin_id'] না থাকলে login page এ পাঠিয়ে দেয়।
 */
function requireLogin()
{
    if (empty($_SESSION['admin_id'])) {
        header('Location: index.php?page=login');
        exit;
    }
}
