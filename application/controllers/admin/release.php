<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Release extends Reim_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('module_model');
        $this->load->model('module_group_model');
        $this->load->model('module_tip_model');
        $this->load->model('app_model');
    }
    public function index() {
        $data['title'] = '包管理';
        $data['description'] = '应用包管理功能模块';
        $data['username'] = $this->session->userdata('username');
        $data['uid'] = $this->session->userdata('uid');
        $data['menu'] = $this->user_model->get_menu($data['uid']);
        $data['tip'] = $this->module_tip_model->get_tip($data['uid']);
        $data['alist'] = $this->app_model->get_all();
        $data['module_group_list'] = $this->module_group_model->get();

        $this->aeload('admin/packages', $data);
    }


    public function add(){
        $platform = $this->input->post('platform');
        $version = $this->input->post('version');
        $uid = $this->session->userdata('uid');
        $buf = $this->_upload($uid, 'package'); 
        log_message("debug", json_encode($buf));
        if($buf['status']){
            $prefix = $buf['prefix']  . '/' . $buf['data']['file_name'];
            $this->app_model->create($platform, $version, $prefix);
        }
        redirect(base_url('admin/release'));
    }

    public function set_online($id = 0){
        if($id == 0) return redirect(base_url('admin/release'));
        $app = $this->app_model->get_one($id);
        if(!$app) return redirect(base_url('admin/release'));

        $online = ($app['online'] == 0) ? 1 : 0;
        $this->app_model->set_default($id, $online);
        $app = $this->app_model->find_online($app['platform']);
        $platform_name = $app['platform'] == 0 ? 'iOS/reim.ipa' : 'android/reim.apk';
        if($app){
            $path = $this->config->item('static_base') . '/' . $app['path'];
            if(file_exists($path)) {
                $dest = BASEPATH . "../release/" . $platform_name;
                @unlink($dest);
                @copy($path, $dest);
            }
        }

        redirect(base_url('admin/release'));
    }

    public function del($id = 0){
        if($id == 0) return redirect(base_url('admin/release'));
        $app = $this->app_model->get_one($id);
        if(!$app) return redirect(base_url('admin/release'));
        $path = $this->config->item('static_base') . '/' . $app['path'];
        if(file_exists($path)) @unlink($path);
        $this->app_model->drop($id);
        redirect(base_url('admin/release'));
    }

}

