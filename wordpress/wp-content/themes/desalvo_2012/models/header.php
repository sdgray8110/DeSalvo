<?php

class Header {
    public function __construct() {
        $this->menu = wp_nav_menu( array('menu' => 'Main Menu', 'echo' => false));
    }
}