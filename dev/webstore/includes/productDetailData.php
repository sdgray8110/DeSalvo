<?php
if (!$phpRoot) {
    $phpRoot = '/home/desalvo/public_html/php/';
}

while ($row = mysql_fetch_array($productData)) {
    $productName = $row['productName'];
    $productPrice = $row['productPrice'];
    $productImages = explode('|', $row['productImages']);
    $imageEl = productImages($productImages, $productID, $productName);
    $productDescription = addLineBreaks($row['productDescription']);
    $quantityInfo = buildQuantity($row['stockStatus']);
    $stockMessaging = $quantityInfo[0];
    $quantityOptions = $quantityInfo[1];
    $styleInfo = productStyles($row['productStyles']);
    $styleCt = $styleInfo[0];
    $styleOptions = $styleInfo[1];

    $pageTitle = $productName;
    $pageData = 'productDetail';

    include($phpRoot . "head.php");

    echo '
<body>
    <div id="page">
    ';

    include($phpRoot . "header.php");
    include($phpRoot . "lists/topnav.php");

    echo '
    <h1>'.$productName.'</h1>
    <ul>
        '.$imageEl.'
    </ul>

    <p>'.$productDescription.'</p>
    <p>'.currency($productPrice).'</p>
    <p>'.$stockMessaging.'</p>
    ';

    if ($quantityOptions) {
        echo '
        <form id="productDetail" name="productDetail" action="formHandlers/addToCart.php" method="post">
            <input type="hidden" name="productID" id="productID" value="'.$productID.'" />
        ';

        if ($styleCt > 1) {
            echo '
                <label for="style">Style:</label>
                <select id="style" name="style">
                    '.$styleOptions.'
                </select>
            ';
        }

        echo '
            <label for="quantity">Quantity:</label>
            <select id="quantity" name="quantity">
                '.$quantityOptions.'
            </select>
            <input type="submit" name="addToCart" id="addToCart" value="Add To Cart" />
        </form>
        ';
    }

    include($phpRoot . "footer.php");

    echo '
    </div>

</body>
</html>
    ';
}
?>