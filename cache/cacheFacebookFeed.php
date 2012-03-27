<?php
require_once('/home/desalvo/public_html/php/facebookFeed.php');
$feed = new facebookFeed();

$feed->cachePosts();

?>