<?php

session_start();

if (!$_SESSION['testSubdir']) {
    $_SESSION['testSubdir'] = 'testSubdir';
}

print_r($_SESSION);
echo session_id();

?>