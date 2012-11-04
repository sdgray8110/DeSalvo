<?php
class FAQ {
    private $id, $data;

    public function __construct() {
        $this->id = 168;
        $this->data = $this->set_faq();
        $this->content = Router::render_template('faq', $this->data);
    }

    private function set_faq() {
        $faq = ac_get_field('accordion_entry', $this->id);

        return array('faq' => $faq);
    }
}