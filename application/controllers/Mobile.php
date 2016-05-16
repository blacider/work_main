<?php

class Mobile extends Reim_Controller {
	public function __construct() {
	    parent::__construct();
	}

    public function weixin_wallet(){
    	$this->load->config('api');
    	$api_url_base = $this->config->item('api_url_base');
   		$this->load->view('mobile/wallet', array(
   			'api_url_base' => $api_url_base
		));
    }
}
