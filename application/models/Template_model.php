<?php

class Template_Model extends Reim_Model{

    public function get_template($template_id) {
        return $this->api_get('report_template/' . $template_id);
    }
}


