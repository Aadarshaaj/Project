<?php
require_once __DIR__ . '/../includes/init.php';
requireAdmin();

if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'delete') {
    $deleteId = (int) $_GET['id'];
    deleteProduct($deleteId);
    flash('Product removed successfully.');
    header('Location: products.php');
    exit;
}

$products = getAllProducts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management | Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="page-admin">
<div class="site-shell">
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main class="container admin-main admin-grid admin-list-page">
        <?php include __DIR__ . '/sidebar.php'; ?>
        <section class="admin-content">
            <section class="section-head">
                <div>
                    <span class="eyebrow">Products</span>
                    <h1>Inventory management</h1>
                </div>
                <a class="btn btn-primary" href="product-form.php">Create product</a>
            </section>
        <section class="admin-table">
            <?php if (empty($products)): ?>
                <div class="empty-state">
                    <h2>No products available</h2>
                    <p>Add a product to begin selling and manage your active catalog here.</p>
                </div>
            <?php else: ?>
                <div class="table-headings">
                    <span>Name</span>
                    <span>Price</span>
                    <span>Status</span>
                    <span>Actions</span>
                </div>
                <?php foreach ($products as $product): ?>
                    <div class="table-row">
                        <div>
                            <strong><?= htmlspecialchars($product['name']) ?></strong>
                            <p class="text-muted"><?= htmlspecialchars($product['tag'] ?? '') ?></p>
                        </div>
                        <span>$<?= number_format($product['price'], 2) ?></span>
                        <span><?= !empty($product['is_active']) ? 'Active' : 'Draft' ?></span>
                        <span class="row-actions">
                            <a class="link-secondary" href="product-form.php?id=<?= $product['id'] ?>">Edit</a>
                            <a class="link-secondary" href="products.php?action=delete&amp;id=<?= $product['id'] ?>">Delete</a>
                        </span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
        </section>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</div>
</body>
</html>
