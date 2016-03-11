<?php

class Bank_Model extends Reim_Model{
    public function __construct() {
        parent::__construct();
    }

    public function get_banks($checksum=0) {

        $jwt = $this->session->userdata('jwt');
        $url = $this->get_url('banks/'.$checksum);
        $buf = $this->do_Get($url, $jwt);

        return json_decode($buf, true);
    }
}

