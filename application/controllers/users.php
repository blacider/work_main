<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->model('group_model', 'groups');
        //$this->load->model('users/customer_model', 'cmodel');  
    }


    public function register(){
    }

    public function update_nickname(){
        $uid = $this->input->post('uid');
        $nickname = $this->input->post('nickname');
        log_message("debug", "update nickname: " . $nickname);
        log_message("debug", "update uid: " . $uid);
        if($uid == 0){
            $info = $this->groups->change_group_name($nickname);
        }else {
            $info = $this->user->update_nickname($uid, $nickname);
        }
        die($info);
    }

    public function update_manager(){
        $uid = $this->input->post('uid');
        $manager = $this->input->post('manager_id');
        log_message("debug", "update manager: " . $manager);
        log_message("debug", "update uid: " . $uid);
        $this->user->update_manager($uid, $manager);
    }
}
