<?php
session_start();
require_once 'db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Web-магазин</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <nav>
        <a href="?page=home">Home</a>
        <a href="?page=products">Products</a>
        <a href="?page=cart">Cart</a>
    </nav>
</header>
<main>
<?php
$page = $_GET['page'] ?? 'home';
switch ($page) 
{
    case "cart":
        require_once("cart.php");
        break;
    case "products":
        require_once("products.php");
        break;
    case "home":
        echo "<h2>Welcome to Web-shop</h2>
              <p>Go to the <strong>Products</strong> tab to view the range of items.</p>";
        break;
    default:
        break;
}
?>
</main>
<footer>
    <p>&copy; 2025 Web-магазин. All rights reserved.</p>
</footer>
</body>
</html>
