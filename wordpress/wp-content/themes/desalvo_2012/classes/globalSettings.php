<?php

class GlobalSettings {
    public function __construct() {
        if (is_admin()) {
            $this->add_actions();
            $this->enqueue_js();
            $this->enqueue_css();
        }
    }

    public function global_settings() {
        add_options_page( 'Global Settings', 'Global Settings', 'manage_options', 'global-settings', array(&$this,'global_settings_page'));
    }

    public function global_settings_page() {
        echo Router::render_template('global_options',$this->get_options());
    }

    private function add_actions() {
        add_action( 'admin_menu', array(&$this,'global_settings'));
        add_action('wp_ajax_update_global_settings', array(&$this,'update_global_settings'));
    }

    public function update_global_settings() {
        unset($_POST['action']);

        foreach ($_POST as $key => $value) {
            update_option($key,$value);
        }

        $data = $this->get_options();
        $data['message'] = 'Settings Updated.';

        echo json_encode($data);

        die();
    }

    private function get_options() {
        $fields = array('webmaster_email','primary_email');
        $data = array();

        foreach ($fields as &$field) {
            $data[$field] = get_option($field);
        }

        return $data;
    }

    private function enqueue_js() {
        wp_register_script('validation', get_stylesheet_directory_uri() . '/js/lib/validation.js');
        wp_register_script('serializeObject', get_stylesheet_directory_uri() . '/js/lib/serializeObject.js');
        wp_register_script('global_settings', get_stylesheet_directory_uri() . '/js/admin/global_settings.js');

        wp_enqueue_script('validation');
        wp_enqueue_script('serializeObject');
        wp_enqueue_script('global_settings');
    }

    private function enqueue_css() {
        wp_register_style('global_settings', get_stylesheet_directory_uri() . '/css/admin/global_settings.css');
        wp_enqueue_style('global_settings');
    }
}