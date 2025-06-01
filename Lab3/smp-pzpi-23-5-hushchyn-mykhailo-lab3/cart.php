<?php
if (session_status() === PHP_SESSION_NONE) 
{
    session_start();
}
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) 
{
    $stmt = $db->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->execute([(int)$_POST['remove']]);
    header("Location: ?page=cart");
    exit;
}
$cartItems = $db->query("
    SELECT cart.id as cart_id, products.id, products.name, products.price, cart.count
    FROM cart
    JOIN products ON products.id = cart.product_id
")->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Shopping Cart</h2>
<?php if ($cartItems): ?>
    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Price</th><th>Count</th><th>Sum</th><th></th>
        </tr>
        <?php $total = 0; foreach ($cartItems as $item): 
            $sum = $item['price'] * $item['count'];
            $total += $sum;
        ?>
        <tr>
            <td><?= $item['id'] ?></td>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td>$<?= $item['price'] ?></td>
            <td><?= $item['count'] ?></td>
            <td>$<?= $sum ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="remove" value="<?= $item['cart_id'] ?>">
                    <button type="submit" class="btn-danger">Remove</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="4"><strong>Total</strong></td>
            <td colspan="2"><strong>$<?= $total ?></strong></td>
        </tr>
    </table>
<?php else: ?>
    <p class="center">Cart is empty. <a href="main.php?page=products">Continue Shopping</a></p>
<?php endif; ?>
