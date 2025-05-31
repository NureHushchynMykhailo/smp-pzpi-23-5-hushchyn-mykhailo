<?php
if (session_status() === PHP_SESSION_NONE) 
{
    session_start();
}
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) 
{
     foreach ($_POST as $key => $value)
      {
        if (strpos($key, 'count_') === 0 && is_numeric($value) && $value > 0) 
        {
            $product_id = (int) str_replace('count_', '', $key);
            $count = (int)$value;
            $stmt = $db->prepare("INSERT INTO cart (product_id, count) VALUES (?, ?)");
            $stmt->execute([$product_id, $count]);
        }
    }
    header("Location: main.php?page=cart");
    exit;
}
$products = $db->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Available Products</h2>
<form method="POST" class="product-list">
    <?php foreach ($products as $product): ?>
        <div>
            <label><?= htmlspecialchars($product['name']) ?> — $<?= $product['price'] ?></label>
            <input type="number" name="count_<?= $product['id'] ?>" value="0" min="0">
        </div>
    <?php endforeach; ?>
    <button type="submit" name="add_to_cart" class="btn">Buy</button>
</form>
