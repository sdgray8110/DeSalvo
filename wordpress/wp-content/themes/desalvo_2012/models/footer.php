<?php

class Footer {
    public function __construct() {
        $this->menu = wp_nav_menu( array('menu' => 'Footer Menu', 'echo' => false));
        $this->year = get_year();
    }
}