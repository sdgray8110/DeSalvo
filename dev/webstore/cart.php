<?php
require_once('includes/config.php');

session_start();
if (!isset($_SESSION['cart'])) {
    $cart = 'There was an error';
} else {
    $cart = explode(':', $_SESSION['cart']);
}

?>

<ul class="cartItems">
    <?php include('includes/cartLineItems.php'); ?>
</ul>
