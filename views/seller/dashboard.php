<?php
$pageTitle = "Seller Dashboard";
$activeNav = "dashboard";
require "includes/header.php";
?>
<div class="seller-layout">
    <?php require "includes/seller-sidebar.php"; ?>
    <main class="seller-main">
        <?php require "includes/seller-topbar.php"; ?>
        <section class="seller-page-content">
            <div class="seller-page-heading">
                <div>
                    <h1>Good morning, <?php echo htmlspecialchars($_SESSION["first_name"]); ?>!</h1>
                    <p>Here's what's happening with your store today.</p>
                </div>
            </div>
            <div class="dashboard-cards">
                <div class="dashboard-card">
                    <span class="dashboard-card-label">Total Sales</span>
                    <strong class="dashboard-card-number">৳<?php echo number_format($totalSales, 2); ?></strong>
                </div>
                <div class="dashboard-card">
                    <span class="dashboard-card-label">Total Orders</span>
                    <strong class="dashboard-card-number"><?php echo $totalOrders; ?></strong>
                </div>
                <div class="dashboard-card">
                    <span class="dashboard-card-label">Total Products</span>
                    <strong class="dashboard-card-number"><?php echo $totalProducts; ?></strong>
                </div>
                <div class="dashboard-card">
                    <span class="dashboard-card-label">Low Stock Items</span>
                    <strong class="dashboard-card-number"><?php echo $lowStock; ?></strong>
                </div>
            </div>
            <section class="seller-dashboard-panel">
                <h2>Recent Orders</h2>
                <div class="table-wrapper">
                    <table class="seller-table">
                        <thead><tr><th>Order ID</th><th>Customer</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead>
                        <tbody>
                        <?php if ($recentOrders && $recentOrders->num_rows > 0): ?>
                            <?php while ($row = $recentOrders->fetch_assoc()): ?>
                                <tr>
                                    <td><strong>#<?php echo htmlspecialchars($row["order_number"]); ?></strong></td>
                                    <td><?php echo htmlspecialchars(trim($row["first_name"]." ".$row["last_name"])); ?></td>
                                    <td>৳<?php echo number_format($row["seller_total"], 2); ?></td>
                                    <td><span class="status-badge status-<?php echo strtolower($row["order_status"]); ?>">
                                        <?php echo htmlspecialchars(ucfirst($row["order_status"])); ?>
                                    </span></td>
                                    <td><?php echo date("M d, Y", strtotime($row["created_at"])); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="empty-table">No recent orders.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
            <section class="seller-dashboard-panel">
                <h2>Quick Actions</h2>
                <div class="quick-actions">
                    <a class="quick-action" href="index.php?page=seller-product-create">
                        <strong>+ Add Product</strong>
                        <span>Create a new product</span>
                    </a>
                    <a class="quick-action" href="index.php?page=seller-products">
                        <strong>Manage Products</strong>
                        <span>View and edit your products</span>
                    </a>
                    <a class="quick-action" href="index.php?page=seller-orders">
                        <strong>View Orders</strong>
                        <span>Manage customer orders</span>
                    </a>
                </div>
            </section>
        </section>
    </main>
</div>
<?php require "includes/footer.php"; ?>