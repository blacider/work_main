<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Thankyou extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
    }

    public function index(){
        if($this->agent->is_mobile()){
            $this->load->view('user/thankyou_mob');
        }else {
            $this->load->view('user/thankyou_web');
        }
    }
}

