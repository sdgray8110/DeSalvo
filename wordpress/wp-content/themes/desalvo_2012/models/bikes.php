<?php

class Bikes {
    protected $id;

    public function __construct() {
        $this->id = get_the_ID();
        $this->title = get_the_title();
        $this->description = ac_get_field('description', $this->id);
        $this->photos = $this->get_photos();
        $this->features = ac_get_field('features', $this->id);
        $this->tubing = ac_get_field('tubing', $this->id);
        $this->faq = $this->get_faq();
        $this->geometry = $this->get_geometry();
        $this->enqueue_js();
    }

    private function get_photos() {
        $photos = new Photos($this->id);

        return $photos->content;
    }

    private function get_geometry() {
        $geometry = new Geometry($this->id);

        return $geometry->content;
    }

    private function get_faq() {
        $faq = new FAQ();

        return $faq->content;
    }

    private function enqueue_js() {
        wp_register_script('carousel', get_stylesheet_directory_uri() . '/js/lib/carousel.js');
        wp_register_script('imageGallery', get_stylesheet_directory_uri() . '/js/lib/imageGallery.js');
        wp_register_script('accordion', get_stylesheet_directory_uri() . '/js/lib/accordion.js');
        wp_register_script('bikes', get_stylesheet_directory_uri() . '/js/bikes.js');

        wp_enqueue_script('carousel');
        wp_enqueue_script('imageGallery');
        wp_enqueue_script('accordion');
        wp_enqueue_script('bikes');
    }
}