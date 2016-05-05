<?php

class Mobile extends Reim_Controller {
	public function __construct() {
	    parent::__construct();
	}

    public function weixin_wallet(){
   		$this->load->view('mobile/wallet', array());
    }

    

}
