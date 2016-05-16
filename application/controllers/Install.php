<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('app_model');
        $this->load->library('user_agent');
    }

    public function index(){
        $android_info = $this->app_model->find_online(1);
        $android_url = "http://d.yunbaoxiao.com/android/" . $android_info['version'] . "/reim.apk";

        $attacker = $this->agent->agent_string();
        $hasAttacker = false;
        if(stripos($attacker, ';JianKongBao Monitor')) {
            $hasAttacker = true;
        }
        $this->load->view('install',
            array(
                'android_url' => $android_url,
                'has_attacker' => $hasAttacker
            )
        );
    }

}
