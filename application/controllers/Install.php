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

    public function newcomer(){
        $jwt = $this->session->userdata('jwt');
        if(!$jwt) return redirect('install');
        $invites = array();
        if ($this->agent->is_mobile('ipad'))
        {
            $info = $this->app_model->find_online(0);
            $url = 'itms-services://?action=download-manifest&url=https://admin.cloudbaoxiao.com/pub/xreim';
            $this->load->view('install/newcomer/iphone', array('url' => $url,'invites' => $invites));
        }
        else if ($this->agent->is_mobile('iphone'))
        {
            $info = $this->app_model->find_online(0);
            $url = 'itms-services://?action=download-manifest&url=https://admin.cloudbaoxiao.com/pub/xreim';
            $this->load->view('install/newcomer/iphone', array('url' => $url,'invites' => $invites));
        }
        else if ($this->agent->is_mobile())
        {
            $info = $this->app_model->find_online(1);
            $url = "https://admin.cloudbaoxiao.com/release/android/" . $info['version'] . "/reim.apk";
            $this->load->view('install/newcomer/android', array('url' => $url,'invites' => $invites));
        }
        else
        {
            $info = $this->app_model->find_online(1);
            $url = "https://admin.cloudbaoxiao.com/release/android/" . $info['version'] . "/reim.apk";
            $this->load->view('install/newcomer/index', array('url' => $url,'invites' => $invites));
        }
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
        $this->load->view('install', array('url' => $url, 'info' => $info, 'platform' => $platform));
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
