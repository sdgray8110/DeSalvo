<?php

foreach ($cart as $item) {
    $item = explode('|', $item);
    $productID = $item[0];
    $style = $item[1];
    $quantity = $item[2];
    $prodInfo = productQuery($productID);

    while($row = mysql_fetch_array($prodInfo)) {
        echo buildCartItem($row, $quantity);
    }
}
?>