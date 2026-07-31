<?php
require_once __DIR__ . '/../includes/init.php';
requireAdmin();

if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'toggle-admin') {
    $userId = (int) $_GET['id'];
    toggleUserAdmin($userId);
    flash('User privileges updated.');
    header('Location: users.php');
    exit;
}

$users = getUsers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management | Admin</title>
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
                    <span class="eyebrow">Users</span>
                    <h1>Customer accounts</h1>
                </div>
                <a class="btn btn-secondary" href="index.php">Back to dashboard</a>
            </section>
        <?php if (empty($users)): ?>
            <div class="empty-state">
                <h2>No user accounts</h2>
                <p>Members will appear here as they register through the storefront.</p>
            </div>
        <?php else: ?>
            <div class="table-headings">
                <span>Name</span>
                <span>Email</span>
                <span>Role</span>
                <span>Actions</span>
            </div>
            <?php foreach ($users as $user): ?>
                <div class="table-row">
                    <div>
                        <strong><?= htmlspecialchars($user['name']) ?></strong>
                        <p class="text-muted"><?= htmlspecialchars(date('M j, Y', strtotime($user['created_at']))) ?></p>
                    </div>
                    <span><?= htmlspecialchars($user['email']) ?></span>
                    <span><?= !empty($user['is_admin']) ? 'Administrator' : 'Customer' ?></span>
                    <span class="row-actions">
                        <?php if ($user['id'] !== currentUser()['id']): ?>
                            <a class="link-secondary" href="users.php?action=toggle-admin&amp;id=<?= $user['id'] ?>">
                                <?= !empty($user['is_admin']) ? 'Revoke admin' : 'Grant admin' ?>
                            </a>
                        <?php else: ?>
                            <span class="text-muted">Current user</span>
                        <?php endif; ?>
                    </span>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        </section>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</div>
</body>
</html>
