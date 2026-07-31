<?php

const DATA_DIR = __DIR__ . '/../data';

function ensureDefaultData(): void
{
    if (!is_dir(DATA_DIR)) {
        mkdir(DATA_DIR, 0755, true);
    }

    if (!file_exists(DATA_DIR . '/products.json')) {
        saveData('products.json', [
            [
                'id' => 1,
                'slug' => 'minimalist-leather-backpack',
                'name' => 'Minimalist Leather Backpack',
                'short_description' => 'A refined backpack for everyday carry.',
                'description' => 'Premium leather, clean lines, and structured support for the modern commuter.',
                'price' => 199.00,
                'tag' => 'Bestseller',
                'image' => 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=1200&q=80',
                'is_active' => true,
            ],
            [
                'id' => 2,
                'slug' => 'signature-travel-tote',
                'name' => 'Signature Travel Tote',
                'short_description' => 'Roomy design and refined detail for travel-ready style.',
                'description' => 'Spacious interior, soft-touch handles, and a luxe silhouette built for daily journeys.',
                'price' => 219.00,
                'tag' => 'New Drop',
                'image' => 'https://images.unsplash.com/photo-1521334884684-d80222895322?auto=format&fit=crop&w=1200&q=80',
                'is_active' => true,
            ],
            [
                'id' => 3,
                'slug' => 'camera-roll-crossbody',
                'name' => 'Camera Roll Crossbody',
                'short_description' => 'A compact crossbody for essentials and style.',
                'description' => 'Structured shape and premium hardware keep your essentials secure while maintaining a polished finish.',
                'price' => 149.00,
                'tag' => 'Featured',
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=1200&q=80',
                'is_active' => true,
            ],
            [
                'id' => 4,
                'slug' => 'carryall-weekender',
                'name' => 'Carryall Weekender',
                'short_description' => 'A premium weekender built for effortless travel.',
                'description' => 'Durable structure, tonal hardware, and refined compartments for a polished carry experience.',
                'price' => 249.00,
                'tag' => 'Featured',
                'image' => 'https://images.unsplash.com/photo-1491553895911-0055eca6402d?auto=format&fit=crop&w=1200&q=80',
                'is_active' => true,
            ],
        ]);
    }

    if (!file_exists(DATA_DIR . '/users.json')) {
        saveData('users.json', [
            [
                'id' => 1,
                'name' => 'Store Admin',
                'email' => 'admin@opulence.test',
                'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
                'is_admin' => true,
                'created_at' => date('c'),
            ],
        ]);
    }

    if (!file_exists(DATA_DIR . '/orders.json')) {
        saveData('orders.json', []);
    }
}

function loadData(string $filename): array
{
    $path = DATA_DIR . '/' . $filename;
    if (!file_exists($path)) {
        return [];
    }

    $json = file_get_contents($path);
    return json_decode($json, true) ?: [];
}

function saveData(string $filename, array $data): bool
{
    $path = DATA_DIR . '/' . $filename;
    if (!is_dir(DATA_DIR)) {
        mkdir(DATA_DIR, 0755, true);
    }

    return file_put_contents($path, json_encode(array_values($data), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) !== false;
}

function getAllProducts(): array
{
    return array_values(loadData('products.json'));
}

function getProducts(): array
{
    return array_values(array_filter(loadData('products.json'), fn($product) => ($product['is_active'] ?? true) === true));
}

function getProductBySlug(string $slug): ?array
{
    return array_values(array_filter(loadData('products.json'), fn($product) => ($product['slug'] ?? '') === $slug))[0] ?? null;
}

function getProductById(int $id): ?array
{
    return array_values(array_filter(loadData('products.json'), fn($product) => ($product['id'] ?? 0) === $id))[0] ?? null;
}

function generateUniqueSlug(string $name, ?int $excludeId = null): string
{
    $baseSlug = slugify($name);
    $slug = $baseSlug;
    $count = 1;
    $products = loadData('products.json');

    while (true) {
        $collision = array_filter($products, function ($product) use ($slug, $excludeId) {
            return ($product['slug'] ?? '') === $slug && ($excludeId === null || ($product['id'] ?? 0) !== $excludeId);
        });

        if (empty($collision)) {
            return $slug;
        }

        $slug = $baseSlug . '-' . ++$count;
    }
}

function saveProducts(array $products): bool
{
    return saveData('products.json', $products);
}

function createProduct(array $data): array
{
    $products = getAllProducts();
    $nextId = getNextId($products);
    $product = [
        'id' => $nextId,
        'slug' => generateUniqueSlug($data['name'] ?? 'product'),
        'name' => trim($data['name'] ?? ''),
        'short_description' => trim($data['short_description'] ?? ''),
        'description' => trim($data['description'] ?? ''),
        'price' => (float) $data['price'],
        'tag' => trim($data['tag'] ?? ''),
        'image' => trim($data['image'] ?? ''),
        'is_active' => !empty($data['is_active']),
    ];
    $products[] = $product;
    saveProducts($products);
    return $product;
}

function updateProduct(int $id, array $data): bool
{
    $products = getAllProducts();
    foreach ($products as $index => $product) {
        if (($product['id'] ?? 0) === $id) {
            $products[$index]['name'] = trim($data['name'] ?? $product['name']);
            $products[$index]['slug'] = generateUniqueSlug($data['name'] ?? $product['name'], $id);
            $products[$index]['short_description'] = trim($data['short_description'] ?? $product['short_description']);
            $products[$index]['description'] = trim($data['description'] ?? $product['description']);
            $products[$index]['price'] = (float) ($data['price'] ?? $product['price']);
            $products[$index]['tag'] = trim($data['tag'] ?? $product['tag']);
            $products[$index]['image'] = trim($data['image'] ?? $product['image']);
            $products[$index]['is_active'] = !empty($data['is_active']);
            return saveProducts($products);
        }
    }

    return false;
}

function deleteProduct(int $id): bool
{
    $products = getAllProducts();
    $filtered = array_values(array_filter($products, fn($product) => ($product['id'] ?? 0) !== $id));
    if (count($filtered) === count($products)) {
        return false;
    }
    return saveProducts($filtered);
}

function getUsers(): array
{
    return loadData('users.json');
}

function saveUsers(array $users): bool
{
    return saveData('users.json', $users);
}

function updateUser(int $id, array $data): bool
{
    $users = getUsers();
    foreach ($users as $index => $user) {
        if (($user['id'] ?? 0) === $id) {
            if (isset($data['name'])) {
                $users[$index]['name'] = trim($data['name']);
            }
            if (isset($data['email'])) {
                $users[$index]['email'] = strtolower(trim($data['email']));
            }
            if (isset($data['is_admin'])) {
                $users[$index]['is_admin'] = !empty($data['is_admin']);
            }
            return saveUsers($users);
        }
    }

    return false;
}

function toggleUserAdmin(int $id): bool
{
    $users = getUsers();
    foreach ($users as $index => $user) {
        if (($user['id'] ?? 0) === $id) {
            $users[$index]['is_admin'] = empty($user['is_admin']) ? true : false;
            return saveUsers($users);
        }
    }
    return false;
}

function findUserByEmail(string $email): ?array
{
    $email = strtolower(trim($email));
    return array_values(array_filter(getUsers(), fn($user) => strtolower($user['email']) === $email))[0] ?? null;
}

function findUserById(int $id): ?array
{
    return array_values(array_filter(getUsers(), fn($user) => ($user['id'] ?? 0) === $id))[0] ?? null;
}

function getNextId(array $items): int
{
    if (empty($items)) {
        return 1;
    }

    return max(array_column($items, 'id')) + 1;
}

function registerUser(string $name, string $email, string $password, bool $isAdmin = false): array
{
    $users = getUsers();
    $user = [
        'id' => getNextId($users),
        'name' => trim($name),
        'email' => strtolower(trim($email)),
        'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        'is_admin' => $isAdmin,
        'created_at' => date('c'),
    ];
    $users[] = $user;
    saveUsers($users);

    return $user;
}

function authenticateUser(string $email, string $password): ?array
{
    $user = findUserByEmail($email);
    if (!$user) {
        return null;
    }

    return password_verify($password, $user['password_hash']) ? $user : null;
}

function currentUser(): ?array
{
    if (!isset($_SESSION['user_id'])) {
        return null;
    }

    return findUserById((int) $_SESSION['user_id']);
}

function isLoggedIn(): bool
{
    return currentUser() !== null;
}

function requireAuth(): void
{
    if (!isLoggedIn()) {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        header('Location: login.php');
        exit;
    }
}

function requireAdmin(): void
{
    requireAuth();

    $user = currentUser();
    if (!$user || !($user['is_admin'] ?? false)) {
        header('Location: login.php');
        exit;
    }
}

function flash(string $message = '', string $type = 'success'): ?array
{
    if ($message !== '') {
        $_SESSION['flash'] = [
            'message' => $message,
            'type' => $type,
        ];
        return null;
    }

    return $_SESSION['flash'] ?? null;
}

function clearFlash(): void
{
    unset($_SESSION['flash']);
}

function getCart(): array
{
    return $_SESSION['cart'] ?? [];
}

function getCartItems(): array
{
    return getCart();
}

function handleCartActions(): void
{
    $action = $_GET['action'] ?? '';
    $productId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

    if ($productId <= 0) {
        return;
    }

    if ($action === 'add') {
        addToCart($productId);
        flash('Added item to your cart.');
        header('Location: cart.php');
        exit;
    }

    if ($action === 'remove') {
        updateCart($productId, 0);
        flash('Removed item from your cart.');
        header('Location: cart.php');
        exit;
    }
}

function getCartCount(): int
{
    return array_reduce(getCart(), fn($sum, $item) => $sum + (($item['quantity'] ?? 0)), 0);
}

function addToCart(int $productId, int $quantity = 1): void
{
    $product = getProductById($productId);
    if (!$product) {
        return;
    }

    $cart = getCart();
    foreach ($cart as &$item) {
        if (($item['id'] ?? 0) === $productId) {
            $item['quantity'] += $quantity;
            $_SESSION['cart'] = $cart;
            return;
        }
    }
    unset($item);

    $cart[] = [
        'id' => $product['id'],
        'name' => $product['name'],
        'price' => $product['price'],
        'image' => $product['image'],
        'quantity' => $quantity,
    ];

    $_SESSION['cart'] = $cart;
}

function updateCart(int $productId, int $quantity): void
{
    $cart = getCart();
    foreach ($cart as $index => $item) {
        if (($item['id'] ?? 0) === $productId) {
            if ($quantity <= 0) {
                unset($cart[$index]);
            } else {
                $cart[$index]['quantity'] = $quantity;
            }
            break;
        }
    }

    $_SESSION['cart'] = array_values($cart);
}

function clearCart(): void
{
    unset($_SESSION['cart']);
}

function saveOrders(array $orders): bool
{
    return saveData('orders.json', $orders);
}

function getOrders(): array
{
    return loadData('orders.json');
}

function getOrderById(int $id): ?array
{
    return array_values(array_filter(getOrders(), fn($order) => ($order['id'] ?? 0) === $id))[0] ?? null;
}

function getOrdersByUser(int $userId): array
{
    return array_values(array_filter(getOrders(), fn($order) => ($order['user_id'] ?? 0) === $userId));
}

function addOrder(array $order): void
{
    $orders = getOrders();
    $order['id'] = getNextId($orders);
    $order['created_at'] = date('c');
    $orders[] = $order;
    saveOrders($orders);
}

function slugify(string $value): string
{
    $value = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower(trim($value)));
    return trim($value, '-');
}

function isAdminArea(): bool
{
    return strpos(str_replace('\\', '/', $_SERVER['SCRIPT_NAME']), '/admin/') !== false;
}

function linkPath(string $path): string
{
    $prefix = isAdminArea() ? '../' : '';
    return $prefix . ltrim($path, '/');
}
