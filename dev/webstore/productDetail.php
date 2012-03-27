<?php
include('includes/config.php');
$productID = $_GET['productID'];
$productData = productQuery($productID);

include('includes/productDetailData.php');

?> 