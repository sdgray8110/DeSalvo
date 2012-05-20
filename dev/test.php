<?php
// This code needs to be included high in any page
// where you want facebook content - this loads the
// collection of functions (class) used to pull the feed
// and give you access to the feed's data
require_once('php/facebookFeed.php');
$feed = new facebookFeed();
$feed->init();
?>


<!--
What you see below is a very simple example of how you will access data from the feed
I've (currently) given you 7 methods - each access a different piece of data. (Date, message
link, like count and the 3 available image sizes) Ignore the <p> tags but you can just drop
the php snippet for each piece into your markup. The number in each method represents the
position of the post in the array - so you have complete control over how many posts show ...
it'll also let you grab a random post or something if you're feeling crazy. 
-->

<p><?php $feed->get_date(1);?></p>
<p><?php $feed->get_message(1);?></p>
<p><?php $feed->get_link(1);?></p>
<p><?php $feed->get_likes(1);?> people like this</p>
<?php $feed->get_thumbnail(1,true); ?>
<?php $feed->get_medium_picture(1,true); ?>
<?php $feed->get_original_picture(1,true); ?>

<p><?php $feed->get_date(2);?></p>
<p><?php $feed->get_message(2);?></p>
<p><?php $feed->get_link(2);?></p>
<p><?php $feed->get_likes(2);?> people like this</p>
<?php $feed->get_thumbnail(2); ?>
<?php $feed->get_medium_picture(2); ?>
<?php $feed->get_original_picture(2); ?>

<p><?php $feed->get_date(3);?></p>
<p><?php $feed->get_message(3);?></p>
<p><?php $feed->get_link(3);?></p>
<p><?php $feed->get_likes(3);?> people like this</p>
<?php $feed->get_thumbnail(3); ?>
<?php $feed->get_medium_picture(3); ?>
<?php $feed->get_original_picture(3); ?>