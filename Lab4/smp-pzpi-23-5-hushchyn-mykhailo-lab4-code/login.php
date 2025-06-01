<?php
if (session_status() === PHP_SESSION_NONE) 
{
    session_start();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    if (isset($_POST['username'], $_POST['password'])) 
    {
        $credentials = require 'credential.php';

        if ($_POST['username'] === $credentials['userName'] && $_POST['password'] === $credentials['password']) {
            $_SESSION['user'] = $_POST['username'];
            $_SESSION['login_time'] = date("Y-m-d H:i:s");
           header("Location: main.php?");
            exit;
        } 
        else 
        {
            $error = 'Неправильний логін або пароль';
        }
    } 
    else 
    {
        $error = 'Заповніть усі поля';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <form method="POST">
        <h2>Login</h2>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <input type="text" name="username" placeholder="Login" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Log In</button>
       
    </form>
</body>
</html>
