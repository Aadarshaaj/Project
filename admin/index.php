<?php
require_once __DIR__ . '/../includes/init.php';
requireAdmin();

$productCount = count(getAllProducts());
$userCount = count(getUsers());
$orderCount = count(getOrders());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Opulence Market</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="page-admin">
<div class="site-shell">
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main class="container admin-main admin-grid">
        <?php include __DIR__ . '/sidebar.php'; ?>
        <section class="admin-content">
            <section class="admin-hero">
                <span class="eyebrow">Admin panel</span>
                <h1>Dashboard</h1>
                <p>Review inventory, orders, and customer activity from a single control center.</p>
            </section>
            <section class="admin-metrics">
            <article class="metric-card">
                <p class="metric-label">Products</p>
                <strong><?= $productCount ?></strong>
            </article>
            <article class="metric-card">
                <p class="metric-label">Customers</p>
                <strong><?= $userCount ?></strong>
            </article>
            <article class="metric-card">
                <p class="metric-label">Orders</p>
                <strong><?= $orderCount ?></strong>
            </article>
        </section>
        <section class="admin-links">
            <a class="admin-card" href="products.php">Manage products</a>
            <a class="admin-card" href="orders.php">Review orders</a>
            <a class="admin-card" href="users.php">Manage users</a>
        </section>
            </section>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</div>
</body>
</html>
