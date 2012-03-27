<?php
require_once('wp-load.php' );

$postID = 16;
$post = get_post($postID);
$images = get_children(
    array(
        'post_parent' => $post->ID,
        'post_type' => 'attachment',
        'order' => 'ASC',
        'orderby' => 'menu_order'
    )
);

$images = array_values($images);
shuffle($images);

print_r($images);