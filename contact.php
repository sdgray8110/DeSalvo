<?php include("php/head.php"); ?>
<body>
<div id="page">

<?php
!$_GET['complete'] ? $contactPage = 'php/contact.php' : $contactPage = 'php/thankYou.php';

include("php/header.php");
include("php/lists/topnav.php");
include($contactPage);
include("php/footer.php");
?>

</div>

</body>
</html>
