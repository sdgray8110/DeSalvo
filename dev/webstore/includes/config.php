<?php

function productQuery($productID) {
    //Connect to database
    $connection = mysql_connect("localhost","desalvo","DfM71772");

    //Debug
    if (!$connection) {
        die ("Database connection failed: " . mysql_error());
    }

    //Select database
    $new_db = mysql_select_db("desalvo_webstore",$connection);

    //Debug
    if (!$new_db) {
        die("Database selection failed: " . mysql_error());
    }

    $qry = 'SELECT * FROM items WHERE productID = ' . $productID;

    $result = @mysql_query($qry, $connection);

    return $result;
}

function productStyles($productStyles) {
    $productStyles = explode('|', $productStyles);
    $styleCt = count($productStyles);

    if ($styleCt > 1) {
        $styleStr = '';
        $i = 0;
        foreach($productStyles as $style) {
            $newStyleStr = '<option value="'.$i.'">'.$style.'</option>';
            $styleStr = $styleStr . $newStyleStr;

            $i++;
        }
    } else {
        $styleStr = $productStyles[0];
    }

    return array($styleCt, $styleStr);
}

function productImages($productImages, $productID, $productName) {
    $imageCt = count($productImages);

    if ($imageCt < 2 && $imageCt > 0) {
        $img = '<li><img src="productImages/' . $productID . '/' .$productImages[0] . '" alt="'.$productName.'" /></li>';
    } else if ($imageCt == 0) {
        $img = '<li><img src="productImages/stock/comingSoon.png" alt="'.$productName.'" /></li>';
    } else {
        $img = loopImages($productImages, $productID, $productName);
    }

    return $img;
}

function loopImages($productImages, $productID, $productName) {
    $img = '';
    foreach($productImages as $image) {
        $newImg = '<li><img src="productImages/' . $productID . '/' . $image . '" alt="'.$productName.'" /></li>';
        $img = $img . $newImg;
    }

    return $img;
}

function addLineBreaks($copy) {
    $replace = array('\r','\n');
    $with = '</p><p>';
    $newCopy = str_replace($replace, $with, $copy);

    return $newCopy;
}

function buildQuantity($stockStatus) {
    if ($stockStatus > 0) {
        $messaging = 'This Item is In Stock!';
        $options = '';
        for ($i = 1; $i <= $stockStatus; $i++) {
            $newOption = '<option value="'.$i.'">'.$i.'</option>';
            $options = $options . $newOption;
        }
    } else {
        $messaging = 'This Item is Currently Out of Stock - Please Check Back Soon!';
        $options = false;
    }
    return array($messaging, $options);
}

function currency($num) {
    $pattern = '%i';
    return '$' . money_format($pattern, $num);
}

/**************/
/*****CART*****/
/**************/

// Builds cart session array
// Returns the passed value on initial add to cart
// Checks for duplicated products and modifies the entry if a match is found
function cartSessionVal($sessionEntry, $init) {
    if ($init === true) {
        return $sessionEntry;
    } else {
        $inCart = itemAlreadyInCart($sessionEntry, $init);

        if ($inCart == false) {
            return $init . ':' . $sessionEntry;
        } else {
            return $inCart;
        }
    }
}

// Checks if item is in cart and returns updated cart array
// Returns false if no match
function itemAlreadyInCart($sessionEntry, $init) {
    $itemList = itemList($init);
    $newItem = explode('|', $sessionEntry);
    $newItemID = $newItem[0];
    $inArray = itemCheck($newItemID, $itemList);

    if ($inArray !== false) {
        $init = rebuildItem($init, $sessionEntry, $inArray);

        return $init;
    } else {
        return false;
    }
}

// Returns position of current item in cart array
// Returns false if no match
function itemCheck($newItemID, $itemList) {
    $i = 0;

    foreach ($itemList as $item) {
        if ($newItemID == $item) {
            return $i;
        }
        $i++;
    }

    return false;
}

// Creates an array from current items, replaces modified item and
// Returns delimited string with updated info
function rebuildItem($init, $sessionEntry, $inArray) {
    $items = explode(':', $init);
    $items[$inArray] = $sessionEntry;
    $newSessionData = implode(':', $items);

    return $newSessionData;
}

// Returns a list of prodIDs currently in the cart
function itemList($init) {
    $items = explode(':', $init);
    $itemList = array();

    foreach ($items as $item) {
        $item = explode('|', $item);
        $itemList[] = $item[0];
    }

    return $itemList;
}


// Takes DB Result and builds line item
function buildCartItem($prodRow, $quantity) {
    $prodId = $prodRow['productID'];
    $name = $prodRow['productName'];
    $price = $prodRow['productPrice'];
    $netPrice = $price * $quantity;

    return '
        <li>
            <h3><a href="productDetail.php?productID='.$prodId.'">'.$name.'</a></h3>
            <span class="price">'.currency($price).'</span>
            <span class="quantity">'.$quantity.'</span>
            <span class="total">'.currency($netPrice).'</span>
        </li>
    ';
}

?>