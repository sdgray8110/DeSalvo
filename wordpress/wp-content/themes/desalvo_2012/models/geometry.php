<?php

class Geometry {
    private $id, $data;

    public function __construct($id) {
        $this->id = $id;
        $this->data = $this->set_geometry();
        $this->content = Router::render_template('geometry', $this->data);
    }

    private function set_geometry() {
        $geometry = ac_get_field('bike_geometry_tables', $this->id);

        return $this->establishFields($geometry);
    }

    private function establishFields($geometry) {
        foreach ($geometry as &$table_group) {
            $table_group['table_group_disclaimers'] = $this->disclaimers($table_group['table_group_disclaimers']);

            foreach ($table_group['table_group'] as &$table) {
                $table['columns'] = array();
                $row = $table['table_row'][0];

                foreach ($row as $key => $value) {
                    if ($value) {
                        $table['columns'][$key] = 1;
                    }
                }
            }
        }

        return array('geometry' => $geometry);
    }

    private function disclaimers($disclaimers) {
        foreach ($disclaimers as &$disclaimer) {
            $disclaimer = $disclaimer['disclaimer'];
        }

        return $disclaimers;
    }
}