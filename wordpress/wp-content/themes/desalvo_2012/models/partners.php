<?php

class Partners {
    protected $id;
    private $post;

    public function __construct() {
        $this->get_post();
        $this->title = $this->post->post_title;
        $this->content = $this->post->post_content;
        $this->name = $this->post->post_name;
        $this->partners = $this->get_partners();
    }

    private function get_post() {
        $this->id = get_the_ID();
        $this->post =  get_post($this->id);
    }

    private function get_partners() {
        return ac_get_field('partners', $this->id);
    }
}