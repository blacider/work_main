<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class REIM_Controller extends CI_Controller{
    private function startsWith($haystack, $needle)
    {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }


    public function __construct(){
        parent::__construct();
        $uri = $this->uri->uri_string();
            log_message("debug", "Request: $uri");
            log_message("debug", "JWT: $uri" . json_encode($this->session->userdata('jwt')));
            log_message("debug", "JWT: $uri" . json_encode($this->session->userdata('uid')));
        if($this->session->userdata('jwt') == "" && $this->session->userdata('uid') == ""){
            log_message("debug", "Not Not Request: $uri");
            $flag = 1;
            $prefixs = array('login', 'register', 'join', 'install', 'errors', 'resetpwd');
            foreach($prefixs as $prefix){
                if($this->startsWith($uri, $prefix)){
                    $flag = 0;
                }
            }
            log_message("debug", "No Auth Info Logout $flag");

            if($flag) redirect(base_url('login'));
        }
    }

    public function  eload($view_name, $custom_data, $menu_page = 'menu.php'){
        $this->load->model('user_model');
        $this->load->model('module_tip_model');
        $uid = $this->session->userdata('uid');
        $profile = $this->session->userdata('profile');
        if(!($profile || $uid)){
            // 重定向到登陆
            log_message("debug","Nothing ");
            redirect(base_url('login'), 'refresh');
        }

        if(!$profile){
            $custom_data['opt_error'] = $this->session->userdata('last_error');
            $custom_data['username'] = $this->session->userdata('username');
            $custom_data['uid'] = $this->session->userdata('uid');
            $custom_data['tip'] = $this->module_tip_model->get_tip($custom_data['uid']);
            $custom_data['menu'] = $this->user_model->get_menu($custom_data['uid']);
            $custom_data['description'] =  '';
        } else {
            $this->session->set_userdata('user', $profile);
            $custom_data['menu'] = $this->user_model->get_menu(0, 1);
            $custom_data['profile'] = $profile;
        }

        $this->config->load('apps', TRUE);
        $custom_data['appname'] = $this->config->item('appname');
        $custom_data['base_url'] = base_url();
        $this->load->view('header', $custom_data);
        $this->load->view($menu_page, $custom_data);
        $this->load->view($view_name, $custom_data);
        $this->load->view('footer', $custom_data);
    }

    public function jsalert($msg, $target = ''){
        if($target){
            die('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><script language="javascript">alert("' . $msg . '"); location.href="' . $target . '";</script>');
        }else {
            die('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><script language="javascript">alert("' . $msg . '"); history.go(-1);</script>');
        }

    }

    public function _pager($url, $total, $pn, $rn){
        $this->load->library('pager');
        $config['base_url'] = base_url($url);
        $config['total'] = $total;
        $config['rn'] = $rn;
        $config['pn'] = $pn;
        $this->pager->initialize($config);
        return $this->pager->create_links();
    }

    public function _upload($uid, $name){
        if($name == "") $name = 'package';
        $this->load->helper('file');
        $user_prefix = md5($uid);
        $s = substr($user_prefix, 0, 2) . "/" . substr($user_prefix, 2, 2);
        $prefix = 'statics/' . 'users_data/' . $s . "/" . $uid . "/" . date('Y/m');
        $config['upload_path'] = $this->config->item('static_base') . $prefix;
        $relate_file = $config['upload_path'];
        if(!file_exists($config['upload_path'])){
            $mkres = mkdir($config['upload_path'], 0777, true);
            if(!$mkres){
                log_message("debug", "mkdir error: " . $config['upload_path']);
                return array('status' => false, 'msg' => '创建目录失败');
            }
        }
        $config['allowed_types'] = '*';
        $config['max_size'] = '50000000';
        $config['encrypt_name'] = True;
        $this->load->library('upload', $config);
        if(!$this->upload->do_upload($name))
        {
            return array('status' => false, 'msg' => '图片上传失败', 'detail' => $this->upload->display_errors());
        } 
        else
        {
            return array('status' => true, 'data' => $this->upload->data(), 'prefix' => $prefix);
        }
    }


    public function  bsload($view_name, $custom_data, $menu_page = 'menu.bs.php'){
        $this->load->model('user_model');
        $this->load->model('module_tip_model');
        $uid = $this->session->userdata('uid');
        $profile = $this->session->userdata('profile');
        if(!($profile || $uid)){
            // 重定向到登陆
            log_message("debug","Nothing ");
            redirect(base_url('login'), 'refresh');
        }

        if(!$profile){
            $custom_data['opt_error'] = $this->session->userdata('last_error');
            $custom_data['username'] = $this->session->userdata('username');
            $custom_data['uid'] = $this->session->userdata('uid');
            $custom_data['tip'] = $this->module_tip_model->get_tip($custom_data['uid']);
            $custom_data['menu'] = $this->user_model->get_menu($custom_data['uid']);
            $custom_data['description'] =  '';
        } else {
            $this->session->set_userdata('user', $profile);
            $custom_data['menu'] = $this->user_model->get_menu(0, 1);
            $custom_data['profile'] = $profile;
        }

        $this->config->load('apps', TRUE);
        $custom_data['appname'] = $this->config->item('appname');
        $custom_data['base_url'] = base_url();
        $this->load->view('header.bs.php', $custom_data);
        $this->load->view($menu_page, $custom_data);
        $this->load->view($view_name, $custom_data);
        $this->load->view('footer.bs.php', $custom_data);
    }


    public function  aeload($view_name, $custom_data){
        $this->load->model('user_model');
        $this->load->model('module_tip_model');
        $uid = $this->session->userdata('uid');
        $profile = $this->session->userdata('profile');
        if(!($profile || $uid)){
            log_message("debug","Nothing ");
            redirect(base_url('login'), 'refresh');
        }

        if(!$profile){
            $custom_data['opt_error'] = $this->session->userdata('last_error');
            $custom_data['username'] = $this->session->userdata('username');
            $custom_data['uid'] = $this->session->userdata('uid');
            $custom_data['tip'] = $this->module_tip_model->get_tip($custom_data['uid']);
            $custom_data['menu'] = $this->user_model->get_menu($custom_data['uid']);
            $custom_data['description'] =  '';
        } else {
            $this->session->set_userdata('user', $profile);
            $custom_data['menu'] = $this->user_model->get_menu(0, 1);
            $custom_data['profile'] = $profile;
        }

        $this->config->load('apps', TRUE);
        $custom_data['appname'] = $this->config->item('appname');
        $this->load->view('header.old.php', $custom_data);
        $this->load->view('menu.old.php', $custom_data);
        $this->load->view($view_name, $custom_data);
        $this->load->view('footer.old.php', $custom_data);
    }

    public function show_error($msg){
    }
}
