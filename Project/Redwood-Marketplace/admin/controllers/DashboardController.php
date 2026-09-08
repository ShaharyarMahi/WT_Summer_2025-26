<?php
/**
 * DashboardController
 * ---------------------
 * For now this just shows a welcome page after login.
 * Real stats (total orders, sales, products, etc.) will be added
 * as a separate feature step, once we cover the Dashboard requirements.
 */

class DashboardController
{
    public function index()
    {
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/dashboard/index.php';
        require __DIR__ . '/../views/layout/footer.php';
    }
}
