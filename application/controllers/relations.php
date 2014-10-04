<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Relations extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('group_model', 'groups');
    }
    public function index(){
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $group = $this->groups->get_my_list();
        $ginfo = array();
        $gmember = array();
        $members = array();
        if($group) {
            $ginfo = $group['data']['ginfo'];
            $gmember = $group['data']['gmember'];
            $gmember = $gmember ? $gmember : array();
            foreach($gmember as &$m){
                $mid = $m['manager_id'];
                if(!array_key_exists($mid, $members)) {
                    $members[$mid] = array();
                }
                log_message("debug", "Gid:". $mid);
                array_push($members[$mid], array('uid' => $m['id'], 'nick' => $m['nickname']));
            }
            print_r($members);
        }
        $this->eload('groups/relations',
            array(
                'title' => '公司管理'
                ,'members' => $members
            )
        );
    }
}
