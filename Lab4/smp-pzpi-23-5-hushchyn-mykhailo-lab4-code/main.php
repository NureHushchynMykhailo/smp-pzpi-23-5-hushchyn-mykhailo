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

<?php require_once("header.php"); ?>

<main>
<?php
$page = $_GET['page'] ?? 'home';
if (!isset($_SESSION['user']) && $page !== 'login') 
{
    require_once("page404.php");
}
else 
{
switch ($page) 
{
    case "cart":
        require_once("cart.php");
        break;
    case "profile":
        require_once("profile.php");
        break;
    case "products":
        require_once("products.php");
        break;
     case "login":
        require_once("login.php");
        break;
    case "logout":
        require_once("logout.php");
        break;
    case "home":
        echo "<h2>Welcome to Web-shop</h2>
              <p>Go to the <strong>Products</strong> tab to view the range of items.</p>";
        break;
    default:
        require_once("page404.php");
        break;
}
}
?>
</main>

<?php require_once("footer.php"); ?>

</body>
</html>
