<h2>Categories</h2>

<?php if (!empty($message)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<div style="background:#fff; padding:20px; border-radius:6px; box-shadow:0 1px 3px rgba(0,0,0,0.1); margin-bottom:25px;">
    <h3 style="margin-bottom:15px;">
        <?= $editCategory ? 'Edit Category' : 'Add New Category' ?>
    </h3>

    <form action="index.php?page=categories" method="POST">
        <?php if ($editCategory): ?>
            <input type="hidden" name="category_id" value="<?= $editCategory['category_id'] ?>">
        <?php endif; ?>

        <div class="form-group">
            <label for="category_name">Category Name</label>
            <input type="text" id="category_name" name="category_name" required
                   value="<?= htmlspecialchars($editCategory['category_name'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3"><?= htmlspecialchars($editCategory['description'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="active" <?= (($editCategory['status'] ?? '') === 'active') ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= (($editCategory['status'] ?? '') === 'inactive') ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn"><?= $editCategory ? 'Update Category' : 'Add Category' ?></button>
        <?php if ($editCategory): ?>
            <a href="index.php?page=categories" class="btn" style="background:#7f8c8d;">Cancel</a>
        <?php endif; ?>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($categories)): ?>
            <tr><td colspan="5" style="text-align:center;">No categories yet.</td></tr>
        <?php else: ?>
            <?php foreach ($categories as $cat): ?>
            <tr>
                <td><?= $cat['category_id'] ?></td>
                <td><?= htmlspecialchars($cat['category_name']) ?></td>
                <td><?= htmlspecialchars($cat['description']) ?></td>
                <td><?= htmlspecialchars($cat['status']) ?></td>
                <td>
                    <a href="index.php?page=categories&edit=<?= $cat['category_id'] ?>" class="btn" style="background:#27ae60; padding:6px 12px;">Edit</a>
                    <a href="index.php?page=categories&delete=<?= $cat['category_id'] ?>" class="btn btn-danger" style="padding:6px 12px;"
                       onclick="return confirm('Delete this category?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>