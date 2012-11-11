<?php

class Contact {
    protected $id;
    private $post;

    public function __construct() {
        $this->get_post();
        $this->title = $this->post->post_title;
        $this->site_name = get_bloginfo('name');
        $this->street_address = ac_get_field('street_address', $this->id);
        $this->city = ac_get_field('city', $this->id);
        $this->phone = ac_get_field('phone', $this->id);
        $this->form_title = ac_get_field('form_title', $this->id);
        $this->submit_button_name = ac_get_field('submit_button_name', $this->id);
        $this->content = $this->post->post_content;
        $this->name = $this->post->post_name;
        $this->pageData = $this->set_page_data();
        $this->set_fields();
        $this->enqueue_js();
    }

    private function get_post() {
        $this->id = get_the_ID();
        $this->post =  get_post($this->id);
    }

    private function set_fields() {
        $fields = ac_get_field('form_fields', $this->id);
        $data = array(
            'fields' => array()
        );

        foreach ($fields as &$field) {

            $type = strtolower($field['field_type']);
            unset($field['field_type']);
            if ($field['field_options']) {
                $field['field_options'] = explode(',',$field['field_options']);

                foreach ($field['field_options'] as &$option) {
                    $option = trim($option);
                }
            }

            $data['fields'][] = array(
                $type => $field
            );
        }

        $this->fields = Router::render_template('contact_form',$data);
    }

    private function enqueue_js() {
        wp_register_script('contact', get_stylesheet_directory_uri() . '/js/contact.js');
        wp_register_script('validation', get_stylesheet_directory_uri() . '/js/lib/validation.js');

        wp_enqueue_script('validation');
        wp_enqueue_script('contact');
    }

    public static function send_contact_email() {
        $to = get_option('primary_email');
        $subject = '[DeSalvo Custom Cycles Website Contact] ' . $_POST['contact_subject'];
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: ' . trim($_POST['contact_name']) . ' <'.$_POST['contact_email'].'>' . "\r\n";
        $message = Router::render_template('contact_us_email',$_POST);

        if ($_POST['contact_department'] == 'Webmaster') {
            $to = get_option('webmaster_email');
        }

        mail($to,$subject,$message,$headers);

        $_POST['update_message'] = Router::render_template('contact_form', array());

        echo json_encode($_POST);

        die();
    }

    private function set_page_data() {
        $data = array(
            'ajaxurl' => admin_url('admin-ajax.php')
        );

        return json_encode($data);
    }
}