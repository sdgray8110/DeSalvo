<?php

add_action( 'after_setup_theme', 'desalvo_setup' );

function desalvo_setup() {
    echo get_the_ID();

    bootstrap_classes();
    enqueue_js();
    add_actions();

    if (is_admin()) {
        new GlobalSettings();
    }
}

function enqueue_js() {
    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', get_stylesheet_directory_uri() . '/js/lib/jquery-1.8.2.min.js');
        wp_register_script('fancybox', get_stylesheet_directory_uri() . '/js/lib/jquery.fancybox.pack.js');
        wp_register_script('serializeObject', get_stylesheet_directory_uri() . '/js/lib/serializeObject.js');
        wp_register_script('global', get_stylesheet_directory_uri() . '/js/global.js');

        wp_enqueue_script('jquery');
        wp_enqueue_script('fancybox');
        wp_enqueue_script('serializeObject');
        wp_enqueue_script('global');
    }
}

function add_actions() {
    add_action('wp_ajax_send_contact_email', array('Contact', 'send_contact_email'));
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