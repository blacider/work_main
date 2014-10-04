<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Relations extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('group_model', 'groups');
    }

    private function _find_leaves($dsrc){
        $src = array();
        foreach($dsrc as &$m){
            $id = $m['id'];
            if(!array_key_exists('children', $m)) $m['children'] = array();
            if(!array_key_exists('icon', $m)) $m['icon'] = base_url('static/img/adminstrator.png'); 
            $src[$id] = $m;
        }
        $pids = array();
        foreach($src as $id => $n){
            array_push($pids, $n['manager_id']);
        }
        $leaves = array();
        foreach($src as $i => $n){
            if(!in_array($n['id'], $pids)) {
                array_push($leaves, $n);
                unset($src[$i]);
            }
        }
        $dsrc = $src;
        foreach($leaves as $n){
            $pid = $n['manager_id'];
            $id = $n['id'];
            array_push($src[$pid]['children'], $n);
            array_unshift($n, $src[$pid]['children']);
            unset($src[$id]);
        }
        return $src;
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
            $leaves = array();
            foreach($gmember as $node){
                array_push($leaves, $node['manager_id']);
            }
            foreach($gmember as &$n){
                $n['icon'] = base_url('statics/img/administrator.png'); 
                if(in_array($n['id'], $leaves)){
                    $n['icon'] = base_url('statics/img/executive.png'); 
                }
            }
            //while(count($gmember) > 1){
            //    $gmember = $this->_find_leaves($gmember);
            //}
        }
        $this->eload('groups/relations',
            array(
                'title' => '公司管理'
                ,'members' => json_encode($gmember)
            )
        );
    }
}
