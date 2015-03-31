<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install extends REIM_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index(){
        $this->load->view('install');
    }
}
