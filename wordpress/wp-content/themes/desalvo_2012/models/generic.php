<?php

class Generic {
    protected $id;
    private $post;

    public function __construct() {
        $this->get_post();
        $this->title = $this->post->post_title;
        $this->content = $this->post->post_content;
    }

    private function get_post() {
        $this->id = get_the_ID();
        $this->post =  get_post($this->id);
    }
}