<?php

add_action( 'after_setup_theme', 'desalvo_setup' );

function desalvo_setup() {
    bootstrap_classes();
}

function get_title() {
	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );
}

function get_html_header() {
    include('html_header.php');
}

function bootstrap_classes() {
    foreach (glob(get_stylesheet_directory() . '/classes/*.php') as $filename) {
        require_once($filename);
    }

    foreach (glob(get_stylesheet_directory() . '/models/*.php') as $filename) {
        require_once($filename);
    }
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