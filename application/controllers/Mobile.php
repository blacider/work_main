<?php

class Mobile extends Reim_Controller {
	public function __construct() {
	    parent::__construct();
	}

    public function weixin_wallet(){
    	// $profile = $this->session->userdata('profile');
    	$profile = array(
    		'nickname'=> 'dasdf'
		);
   		$this->load->view('mobile/wallet', $profile);
    }
}
