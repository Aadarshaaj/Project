<?php
$currentUser = currentUser();
$cartCount = getCartCount();
$flash = flash();
?>
<header class="site-header site-header--glass">
    <div class="container header-inner">
        <a class="brand" href="<?= linkPath('index.php') ?>">Opulence<span>Market</span></a>
        <nav class="site-nav">
            <a href="<?= linkPath('index.php') ?>">Home</a>
            <a href="<?= linkPath('shop.php') ?>">Shop</a>
            <a href="<?= linkPath('cart.php') ?>">Cart <span class="nav-counter"><?= $cartCount ?></span></a>
            <?php if ($currentUser): ?>
                <a href="<?= linkPath('account.php') ?>">Account</a>
                <?php if (!empty($currentUser['is_admin'])): ?>
                    <a href="<?= linkPath('admin/index.php') ?>">Admin</a>
                <?php endif; ?>
                <a href="<?= linkPath('logout.php') ?>">Logout</a>
            <?php else: ?>
                <a href="<?= linkPath('register.php') ?>">Register</a>
                <a href="<?= linkPath('login.php') ?>">Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<?php if ($flash): ?>
    <section class="toast-banner">
        <div class="toast">
            <strong><?= htmlspecialchars($flash['message']) ?></strong>
        </div>
    </section>
    <?php clearFlash(); ?>
<?php endif; ?>
