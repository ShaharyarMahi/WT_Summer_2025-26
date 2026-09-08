<h2>Products</h2>

<?php if (!empty($message)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Store</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($products)): ?>
            <tr><td colspan="8" style="text-align:center;">No products yet.</td></tr>
        <?php else: ?>
            <?php foreach ($products as $p): ?>
            <tr>
                <td><?= $p['product_id'] ?></td>
                <td><?= htmlspecialchars($p['product_name']) ?></td>
                <td><?= htmlspecialchars($p['category_name'] ?? '-') ?></td>
                <td><?= htmlspecialchars($p['store_name'] ?? '-') ?></td>
                <td><?= number_format($p['price'], 2) ?></td>
                <td><?= $p['stock_quantity'] ?? 0 ?></td>
                <td><?= htmlspecialchars($p['status']) ?></td>
                <td>
                    <a href="index.php?page=products&toggle=<?= $p['product_id'] ?>" class="btn" style="background:#27ae60; padding:6px 12px;">Toggle Status</a>
                    <a href="index.php?page=products&delete=<?= $p['product_id'] ?>" class="btn btn-danger" style="padding:6px 12px;"
                       onclick="return confirm('Delete this product?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>