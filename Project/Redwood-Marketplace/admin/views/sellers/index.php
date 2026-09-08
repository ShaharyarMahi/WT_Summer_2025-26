<h2>Sellers</h2>

<?php if (!empty($message)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Store Name</th>
            <th>Seller</th>
            <th>Email</th>
            <th>Rating</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($stores)): ?>
            <tr><td colspan="7" style="text-align:center;">No seller stores yet.</td></tr>
        <?php else: ?>
            <?php foreach ($stores as $s): ?>
            <tr>
                <td><?= $s['store_id'] ?></td>
                <td><?= htmlspecialchars($s['store_name']) ?></td>
                <td><?= htmlspecialchars(($s['first_name'] ?? '') . ' ' . ($s['last_name'] ?? '')) ?></td>
                <td><?= htmlspecialchars($s['email'] ?? '-') ?></td>
                <td><?= $s['rating'] ?></td>
                <td><?= htmlspecialchars($s['store_status']) ?></td>
                <td>
                    <?php if ($s['store_status'] !== 'active'): ?>
                        <a href="index.php?page=sellers&approve=<?= $s['store_id'] ?>" class="btn" style="background:#27ae60; padding:6px 12px;">Approve</a>
                    <?php endif; ?>
                    <?php if ($s['store_status'] !== 'suspended'): ?>
                        <a href="index.php?page=sellers&suspend=<?= $s['store_id'] ?>" class="btn btn-danger" style="padding:6px 12px;"
                           onclick="return confirm('Suspend this store?')">Suspend</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>