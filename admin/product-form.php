<?php
require_once __DIR__ . '/../includes/init.php';
requireAdmin();

$product = null;
$errors = [];

if (isset($_GET['id'])) {
    $product = getProductById((int) $_GET['id']);
    if (!$product) {
        header('Location: products.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => trim($_POST['name'] ?? ''),
        'short_description' => trim($_POST['short_description'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'price' => $_POST['price'] ?? 0,
        'tag' => trim($_POST['tag'] ?? ''),
        'image' => trim($_POST['image'] ?? ''),
        'is_active' => isset($_POST['is_active']),
    ];

    if ($data['name'] === '') {
        $errors[] = 'Product name is required.';
    }
    if (!is_numeric($data['price']) || (float) $data['price'] <= 0) {
        $errors[] = 'Price must be a valid number above 0.';
    }

    if (empty($errors)) {
        if ($product) {
            updateProduct($product['id'], $data);
            flash('Product updated successfully.');
        } else {
            createProduct($data);
            flash('Product added successfully.');
        }
        header('Location: products.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product ? 'Edit product' : 'Create product' ?> | Admin</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="page-admin">
<div class="site-shell">
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main class="container admin-main admin-grid admin-form-page">
        <?php include __DIR__ . '/sidebar.php'; ?>
        <section class="admin-content">
            <section class="section-head">
                <div>
                    <span class="eyebrow">Product</span>
                    <h1><?= $product ? 'Edit product' : 'Create new product' ?></h1>
                </div>
                <a class="btn btn-secondary" href="products.php">Back to products</a>
            </section>
            <form method="POST" class="admin-form">
            <?php if (!empty($errors)): ?>
                <div class="form-error-list">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <label for="name">Product name</label>
            <input id="name" name="name" type="text" value="<?= htmlspecialchars($product['name'] ?? '') ?>" required>
            <label for="short_description">Short description</label>
            <input id="short_description" name="short_description" type="text" value="<?= htmlspecialchars($product['short_description'] ?? '') ?>">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
            <label for="price">Price</label>
            <input id="price" name="price" type="number" step="0.01" value="<?= htmlspecialchars($product['price'] ?? '') ?>" required>
            <label for="tag">Tag</label>
            <input id="tag" name="tag" type="text" value="<?= htmlspecialchars($product['tag'] ?? '') ?>">
            <label for="image">Image URL</label>
            <input id="image" name="image" type="url" value="<?= htmlspecialchars($product['image'] ?? '') ?>">
            <label class="checkbox-label">
                <input type="checkbox" name="is_active" <?= !empty($product['is_active']) || !$product ? 'checked' : '' ?>> Active
            </label>
            <button type="submit" class="btn btn-primary"><?= $product ? 'Save product' : 'Create product' ?></button>
        </form>
        </section>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</div>
</body>
</html>
