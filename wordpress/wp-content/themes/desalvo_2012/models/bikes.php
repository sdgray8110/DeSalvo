<?php

class Bikes {
    protected $id;

    public function __construct() {
        $this->id = get_the_ID();
        $this->title = get_the_title();
        $this->description = ac_get_field('description', $this->id);
    }
}