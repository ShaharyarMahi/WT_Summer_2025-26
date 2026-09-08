<?php
$pageTitle = "Seller Orders";
$activeNav = "orders";
require "includes/header.php";
?>
<div class="seller-layout">
    <?php require "includes/seller-sidebar.php"; ?>
    <main class="seller-main">
        <?php require "includes/seller-topbar.php"; ?>
        <section class="seller-page-content">
            <div class="seller-page-heading">
                <div>
                    <h1>Orders</h1>
                    <p>Manage and fulfill customer orders from your store.</p>
                </div>
                <div class="list-toolbar">
                    <input type="text" class="search-input" placeholder="Search orders..." id="orderSearch">
                    <button class="secondary-button">Filter</button>
                </div>
            </div>

            <?php
            $statusCounts = ["all" => 0, "pending" => 0, "processing" => 0,
                             "shipped" => 0, "delivered" => 0, "cancelled" => 0];
            $ordersList = [];
            if ($orders && $orders->num_rows > 0) {
                while ($row = $orders->fetch_assoc()) {
                    $ordersList[] = $row;
                    $statusCounts["all"]++;
                    $key = strtolower($row["order_status"]);
                    if (isset($statusCounts[$key])) $statusCounts[$key]++;
                }
            }
            $currentFilter = $_GET["status"] ?? "all";
            $filtered = array_filter($ordersList, function($o) use ($currentFilter) {
                return $currentFilter === "all" || strtolower($o["order_status"]) === $currentFilter;
            });
            ?>

            <div class="status-tabs">
                <?php foreach ($statusCounts as $key => $count): ?>
                    <a class="status-tab <?php echo $currentFilter === $key ? 'active' : ''; ?>"
                       href="index.php?page=seller-orders&status=<?php echo $key; ?>">
                        <?php echo ucfirst($key === 'all' ? 'All Orders' : $key); ?>
                        <span class="tab-count"><?php echo $count; ?></span>
                    </a>
                <?php endforeach; ?>
            </div>

            <section class="seller-table-panel">
                <div class="table-wrapper">
                    <table class="seller-table" id="orderTable">
                        <thead><tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Order Date</th>
                            <th>Actions</th>
                        </tr></thead>
                        <tbody>
                        <?php if (!empty($filtered)): ?>
                            <?php foreach ($filtered as $order): ?>
                                <tr>
                                    <td><strong>#<?php echo htmlspecialchars($order["order_number"]); ?></strong></td>
                                    <td><?php echo htmlspecialchars(trim($order["first_name"]." ".$order["last_name"])); ?></td>
                                    <td><em>see order items</em></td>
                                    <td>৳<?php echo number_format($order["seller_total"], 2); ?></td>
                                    <td><span class="status-badge status-<?php echo strtolower($order["order_status"]); ?>">
                                        <?php echo htmlspecialchars(ucfirst($order["order_status"])); ?>
                                    </span></td>
                                    <td><?php echo date("M d, Y", strtotime($order["created_at"])); ?></td>
                                    <td><a class="btn-primary-small" href="#">View</a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="empty-table">No orders found.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </section>
    </main>
</div>

<script>
document.getElementById('orderSearch').addEventListener('keyup', function() {
    const search = this.value.toLowerCase();
    const rows = document.querySelectorAll('#orderTable tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(search) ? '' : 'none';
    });
});
</script>
<?php require "includes/footer.php"; ?>