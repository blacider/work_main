<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends Reim_Controller {
    private $_err_code;
    public function __construct(){
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index()
    {
        $data['uid'] = $this->session->userdata('uid');
        $data['menu'] = $this->user_model->get_menu($data['uid']);

        if(!empty($data['menu'])){
            foreach($data['menu'] as $_menu){
                if($_menu->type == 'module'){
                    $url = $_menu->path;
                    break;
                }
            }
            die($url);
            return redirect($url, 'refresh');
        }
        else{
            die('无权访问本系统功能');
        }
    }


}
