<aside class="admin-sidebar">
    <div class="sidebar-brand">
        <span class="eyebrow">Admin</span>
        <h2>Control Center</h2>
        <p class="sidebar-copy">Manage products, orders, customers, and site access from one polished admin experience.</p>
    </div>
    <nav class="sidebar-nav">
        <a href="index.php" class="<?= basename($_SERVER['SCRIPT_NAME']) === 'index.php' ? 'active' : '' ?>">Dashboard</a>
        <a href="products.php" class="<?= basename($_SERVER['SCRIPT_NAME']) === 'products.php' ? 'active' : '' ?>">Products</a>
        <a href="orders.php" class="<?= basename($_SERVER['SCRIPT_NAME']) === 'orders.php' ? 'active' : '' ?>">Orders</a>
        <a href="users.php" class="<?= basename($_SERVER['SCRIPT_NAME']) === 'users.php' ? 'active' : '' ?>">Users</a>
        <a href="product-form.php" class="<?= basename($_SERVER['SCRIPT_NAME']) === 'product-form.php' ? 'active' : '' ?>">New product</a>
        <a href="../shop.php">View storefront</a>
        <a href="../logout.php">Sign out</a>
    </nav>
</aside>
