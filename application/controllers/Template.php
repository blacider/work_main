<?php 

if(!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Template extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('template_model');
    }

    public function get_template($template_id=0)
    {
    	// var_dump($template_id);
    	// $template_id = 0;
    	// var_dump($template_id);
    	$buf = $this->template_model->get_template($template_id);
    	die(json_encode($buf));
    }
}
