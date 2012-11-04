<?php

class Photos {
    private $id, $data;

    public function __construct($id) {
        $this->id = $id;
        $this->data = $this->set_photos();
        $this->content = Router::render_template('photos', $this->data);
    }

    private function set_photos() {
        $photos = ac_get_field('photos', $this->id);
        shuffle($photos);

        return array(
            'photos' => $this->hydratePhotos($photos),
            'primary' => $photos[0]
        );
    }

    private function hydratePhotos($photos) {
        $len = count($photos);

        for ($i = 0; $i < $len; $i++) {
            if ($i == 0) {
                $photos[$i]['active'] = 1;
            } elseif ($i == $len -1) {
                $photos[$i]['last'] = 1;
            }
        }

        return $photos;
    }

}