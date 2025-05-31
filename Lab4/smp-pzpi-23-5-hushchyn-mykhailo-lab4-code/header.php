<head>
    <meta charset="UTF-8">
    <title>Web-магазин</title>
    <link rel="stylesheet" href="style.css">
</head>
<header>
    <nav>
        <a href="?page=home">Home</a>
        <a href="?page=products">Products</a>
        <a href="?page=cart">Cart</a>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="?page=profile">Profile</a>
            <a href="?page=logout">Logout</a>
        <?php else: ?>
            <a href="?page=login">Login</a>
        <?php endif; ?>
    </nav>
</header>
