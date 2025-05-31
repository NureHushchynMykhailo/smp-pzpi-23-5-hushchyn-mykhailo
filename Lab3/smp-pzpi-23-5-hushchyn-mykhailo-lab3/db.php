<?php
try 
{

$db = new PDO('sqlite:' . __DIR__ . '/shop.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
} catch (PDOException $e) 
{
    die("DB Error: " . $e->getMessage());
}
?>
