<?php

class Homepage {
    protected $imagesPageID;

    public function __construct() {
        $this->parentTemplate = 'default';
        $this->imagesPageID = 57;
        $this->mainImage = (object) $this->get_random_image();
        $this->feed = $this->get_fb_feed();
        $this->awards = new Awards();
    }

    private function get_random_image() {
        $images = ac_get_field('images', $this->imagesPageID);

        return $images[rand(0,count($images) - 1)]['image'];
    }

    public function get_fb_feed() {
        $fb_posts = new fb_posts();
        $feeds = $fb_posts->get_fb_feeds();
        $feed = $feeds['DeSalvo'];

        foreach ($feed as &$post) {
            $post->likes->count = $post->likes->count ? $post->likes->count : 0;
            $persons = $post->likes->count == 1 ? 'person' : 'people';
            $fmt = '%s %s like this';

            $post->likes->formatted = sprintf($fmt,$post->likes->count, $persons);
            $post->date->formatted = date('l, M j, Y', strtotime($post->created_time));
        }

        return $feed;
    }
}