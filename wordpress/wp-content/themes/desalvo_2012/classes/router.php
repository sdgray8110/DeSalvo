<?php

class Router {
    protected $themePath, $m, $post;

    public function __construct($post) {
        $this->themePath = get_stylesheet_directory();
        $this->post = $post;
        $this->m = $this->bootstrapMustache();
        $this->content = $this->get_page();
    }

    private function bootstrapMustache() {
        require_once($this->themePath . '/mustache.php/src/Mustache/Autoloader.php');
        Mustache_Autoloader::register();

        return new Mustache_Engine(array(
            'loader' => new Mustache_Loader_FilesystemLoader($this->themePath . '/templates')
        ));
    }

    private function get_data($name) {
        $classname = ucfirst($name);

        return new $classname();
    }

    private function get_view($name = null) {
        $name = $name ? $name : $this->post->name;
        $data = $this->get_data($name);
        $tpl = $this->m->loadTemplate($name);

        return $tpl->render($data);
    }

    private function get_page() {
        $page = array(
            'header' => $this->get_view('header'),
            'content' => $this->get_view($this->post->name),
            'footer' => $this->get_view('footer')
        );

        $template = $this->m->loadTemplate('default');

        return $template->render($page);
    }
}