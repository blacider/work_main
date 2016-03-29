<?php

class Template_Model extends Reim_Model{
    public function __construct() {
        parent::__construct();
    }

    public function get_template($template_id) {

        $jwt = $this->session->userdata('jwt');
         
        $url = $this->get_url('report_template/' . $template_id);

        $buf = $this->do_Get($url, $jwt);

        return json_decode($buf, true);
    }
}


