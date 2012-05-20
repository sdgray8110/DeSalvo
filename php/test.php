<?php

session_start();

if (!$_SESSION['test1']) {
    $_SESSION['test1'] = 'test1';
}

    $_SESSION['test2'] = 'test2';
    $_SESSION['test3'] = 'test3';
    $_SESSION['test4'] = 'test4';

print_r($_SESSION);

echo "<br />#" . session_id();

?>