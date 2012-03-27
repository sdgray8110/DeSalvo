<?php
require_once('../includes/config.php');

$productID = $_POST['productID'];
$style = $_POST['style'];
$quantity = $_POST['quantity'];
$sessionEntry = $productID . '|' . $style . '|' . $quantity;

session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = cartSessionVal($sessionEntry, true);
} else {
    $_SESSION['cart'] = cartSessionVal($sessionEntry, $_SESSION['cart']);
}

header("Location: /cart.php");
exit;

?>
