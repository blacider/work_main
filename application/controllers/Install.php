<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('app_model');
        $this->load->library('user_agent');
        $this->load->model('user_model','user');
    }
    public function stage(){
        $this->load->view('stage');
    }


    public function index(){
        $info = $this->app_model->find_online(0);
        $platform = 'ios';
        if ($this->agent->is_mobile('ipad') || $this->agent->is_mobile('iphone'))
        {
            $url = 'itms-services://?action=download-manifest&url=https://admin.cloudbaoxiao.com/pub/xreim';
            $platform = 'ios';
        }
        else if($this->agent->is_mobile('android'))
        {
            $info = $this->app_model->find_online(1);
            $url = "http://d.yunbaoxiao.com/android/" . $info['version'] . "/reim.apk";
            $platform = 'android';
        } else { //pc
            $url = '';
            $platform = 'pc';
        }

        $attacker = $this->agent->agent_string();
        // $attacker = "test start; ;JianKongBao Monitor test end";
        $hasAttacker = false;
        if(stripos($attacker, ';JianKongBao Monitor')) {
            $hasAttacker = true;
        }
        $this->load->view('install', 
            array(
                'url' => $url,
                'info' => $info,
                'platform' => $platform,
                'has_attacker' => $hasAttacker
            )
        );
    }

    public function wx(){
        if ($this->agent->is_mobile('iphone'))
        {
            $this->load->view('wx/index');
        }
        else if ($this->agent->is_mobile())
        {
            $this->load->view('wx/adroid');
        }
        else
        {
            $this->load->view('wx/index');
        }
        //        $this->load->view('install');
    }


}
