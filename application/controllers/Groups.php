<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends REIM_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usergroup_model');
        $this->load->model('group_model');
    }

    public function update(){
        $this->need_group_agent();
        $pid = $this->input->post('pgroup');
        $code = $this->input->post('gcode');
        $manager = $this->input->post('manager');
        $name = $this->input->post('gname');
        $uids = $this->input->post('uids');
        $pid = $this->input->post('pgroup');
        $manager = $this->input->post('manager');
        $uids = implode(",", $uids);
        $images = '';
        $_images = $this->input->post('images');
        if($_images)
        {
            $images = $_images;
        }
        $info = $this->usergroup_model->create_group($manager,$uids, $name,$code,$pid,$images);

        if($info['status'] > 0) {
            $this->session->set_userdata('last_error','创建部门成功');
        } else {
            $this->session->set_userdata('last_error',$info['data']['msg']);
        }
        redirect(base_url('members/index'));
    }

    public function delete() {
        $error = $this->session->userdata('last_error');
        // 获取当前所属的组
        $this->session->unset_userdata('last_error');
        $id = $this->input->post('id');
        $buf = $this->group_model->delete_group($id);
        if ($buf['status'] > 0) {
            $this->session->set_userdata('last_error', '删除部门成功');
        }
        die(json_encode($buf));
    }

}

