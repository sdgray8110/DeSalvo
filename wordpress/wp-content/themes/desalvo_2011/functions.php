<?php

function get_title() {

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

}

function get_html_header() {
    include('html_header.php');
}

function homepage_random_image() {
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

    return $images[0];
}

if ( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus(
		array(
            'header_menu' => 'Main Menu',
            'footer_menu' => 'Footer Menu'
		)
	);
}

function get_year() {
    return date('Y');
}

?>