<?php

class PageHelper {
    protected $themePath, $post, $name;

    public function __construct($name =  null) {
        $this->name = $name;
        $this->themePath = get_stylesheet_directory();
        $this->post = $this->get_post();
    }

    private function get_post() {
        $pageData = new stdClass();
        $pageData->id = get_the_ID();
        $pageData->post = $pageData->id ? get_post($pageData->id) : '';
        $pageData->name = $this->name ? $this->name : $pageData->post->post_name ;

        return $pageData;
    }

    public function content() {
        $router = new Router($this->post);

        echo $router->content;
    }
}