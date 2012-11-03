<?php
class Awards {
    protected $id;

    public function __construct() {
        $this->id = 62;
        $this->get_awards();
    }

    private function get_awards() {
        $this->title = get_the_title($this->id);
        $this->description = get_field('awards_description', $this->id);
        $this->image =  $obj = get_field('awards_image', $this->id);
        $this->link =  get_field('awards_link', $this->id);
        $this->awards =  get_field('awards', $this->id);
    }
}