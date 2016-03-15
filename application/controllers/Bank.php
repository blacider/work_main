<?php

class Bank extends Reim_Controller {
	public function __construct() {
	    parent::__construct();
	    $this->load->model('bank_model', 'bank');
	}

    public function get_banks($checksum=0){
    	$buf =$this->bank->get_banks($checksum);
    	die(json_encode($buf));
    }
}
