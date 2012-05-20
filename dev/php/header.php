<?php
echo '
<div class="header">
    <div class="headerleft">
        <a href="'.$contextRoot.'index.php"><img class="txt" src="'.$contextRoot.'images/txt.png" border="none" alt="DeSalvo"/></a>
        <img class="badge" src="'.$contextRoot.'images/badge.png" alt="badge"/>
    </div>
    <div class="headerright">
        ';
    include($phpRoot . "social.php");
echo '
        <p>
        541.488.8400



        </p>
    </div>
</div>
';
?>

<!-- shopping cart link to be re-added when the e-commerce site goes live
<img src="'.$contextRoot.'images/cart.png" alt="shopping cart"/> Cart
-->