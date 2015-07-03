<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
    }
    public function stage(){
        $this->load->view('stage');
    }

    public function index(){
        if ($this->agent->is_mobile('iphone'))
        {
            $this->load->view('install/iphone');
        }
        else if ($this->agent->is_mobile())
        {
            $this->load->view('install/android');
        }
        else
        {
            $this->load->view('install/index');
        }
        //        $this->load->view('install');
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
