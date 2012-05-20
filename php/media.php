<?php
// This code needs to be included high in any page
// where you want facebook content - this loads the
// collection of functions (class) used to pull the feed
// and give you access to the feed's data
require_once('php/facebookFeed.php');
$feed = new facebookFeed();
$feed->init();
?>
<div class="updates">
    <p>Updates from the Shop</p>
    <div class="facebook">
		<div class="facebookcontent">
            <div class="fbleft">
                <a class="thumb" rel="superbox[image]" href="<?php $feed->get_original_picture(1, true); ?>"><?php $feed->get_thumbnail(1); ?></a>
                <h5><?php $feed->get_date(1);?> | <a href="<?php $feed->get_link(1);?>"><?php $feed->get_likes(1);?></a></h5>
                <p><?php $feed->get_message(1);?></p>
            </div>
            <div class="fbright">
                <a class="thumb" rel="superbox[image]" href="<?php $feed->get_original_picture(2, true); ?>"><?php $feed->get_thumbnail(2); ?></a>
                <h5><?php $feed->get_date(2);?> | <a href="<?php $feed->get_link(2);?>"><?php $feed->get_likes(2);?></a></h5>
                <p><?php $feed->get_message(2);?></p>
            </div>
		</div>
	</div>
</div>
