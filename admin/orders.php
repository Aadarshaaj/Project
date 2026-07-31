<?php
require_once __DIR__ . '/../includes/init.php';
requireAdmin();

$orders = getOrders();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management | Admin</title>
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
                    <span class="eyebrow">Orders</span>
                    <h1>Order history</h1>
                </div>
                <a class="btn btn-secondary" href="index.php">Back to dashboard</a>
            </section>
        <?php if (empty($orders)): ?>
            <div class="empty-state">
                <h2>No orders yet</h2>
                <p>Customer orders will appear here as they are placed through the storefront.</p>
            </div>
        <?php else: ?>
            <div class="table-headings">
                <span>Order</span>
                <span>Customer</span>
                <span>Total</span>
                <span>Status</span>
            </div>
            <?php foreach ($orders as $order): ?>
                <?php $customer = findUserById($order['user_id'] ?? 0); ?>
                <div class="table-row">
                    <div>
                        <strong>#<?= htmlspecialchars($order['id']) ?></strong>
                        <p class="text-muted"><?= date('M j, Y', strtotime($order['created_at'])) ?></p>
                    </div>
                    <span><?= htmlspecialchars($customer['email'] ?? 'Guest') ?></span>
                    <span>$<?= number_format($order['total'] ?? 0, 2) ?></span>
                    <span><?= htmlspecialchars($order['status'] ?? 'Processing') ?></span>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        </section>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</div>
</body>
</html>
