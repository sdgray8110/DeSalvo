<?php

class Buildkits {
    protected $id;
    private $post;

    public function __construct() {
        $this->get_post();
        $this->title = $this->post->post_title;
        $this->content = $this->post->post_content;
        $this->name = $this->post->post_name;
        $this->get_brands();
        $this->enqueue_js();
    }

    private function get_post() {
        $this->id = get_the_ID();
        $this->post =  get_post($this->id);
    }

    private function get_brands() {
        $brands = ac_get_field('build_kit',$this->id);

        foreach ($brands as &$brand) {
            $brand['brand_logo'] = $brand['brand_logo']['sizes']['large'];
        }

        $this->brands = $brands;
    }

    private function enqueue_js() {
        wp_register_script('masonry', get_stylesheet_directory_uri() . '/js/lib/masonry.min.js');
        wp_register_script('buildkits', get_stylesheet_directory_uri() . '/js/buildkits.js');

        wp_enqueue_script('masonry');
        wp_enqueue_script('buildkits');
    }
}