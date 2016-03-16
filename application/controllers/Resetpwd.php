<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Resetpwd extends REIM_Controller  {
    public function __construct(){   
        parent::__construct(); 
        $this->load->model('user_model');  
        $this->load->model('user_model', 'users');
        $this->load->helper('cookie');
        $this->cookie_register_name = 'register_cookie';
        $this->cookie_user = 'name';
        // 设置cookie有效期为30天
        $this->cookie_life = 86400 * 30;
        $this->load->library('user_agent');
    }


    public function index($code = '', $name = '') {
        /*
        if(!$code || !$cid) redirect(base_url('login'));
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $this->load->view('resetpwd', array('code' => $code, 'cid' => $cid, 'error' => $error));
         */
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $this->input->set_cookie($this->cookie_register_name, $code, $this->cookie_life);
        //$name = urldecode($name);
        $args = array('name' => '');
        if($name){
            $args = json_decode(urldecode($name), True);
        }
        $this->input->set_cookie($this->cookie_user, $args['name'], $this->cookie_life);
        $this->load->view('resetpwd', array('active'=>0,'name' => $args['name'], 'code' => $code, 'cid' => $name, 'error' => $error));
        //$this->load->view('user/register', array('name' => $args['name']));
    }

    public function active($code = '', $name = '') {
        /*
        if(!$code || !$cid) redirect(base_url('login'));
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $this->load->view('resetpwd', array('code' => $code, 'cid' => $cid, 'error' => $error));
         */
        $error = $this->session->userdata('last_error');
        $this->session->unset_userdata('last_error');
        $this->input->set_cookie($this->cookie_register_name, $code, $this->cookie_life);
        //$name = urldecode($name);
        $args = array('name' => '');
        if($name){
            $args = json_decode(urldecode($name), True);
        }
        $this->input->set_cookie($this->cookie_user, $args['name'], $this->cookie_life);
        $this->load->view('resetpwd', array('active'=>1,'name' => $args['name'], 'code' => $code, 'cid' => $name, 'error' => $error));
        //$this->load->view('user/register', array('name' => $args['name']));
    }

    public function doupdate($active,$is_newcomer=0){
        $pass = $this->input->post('pass');
        $repass = $this->input->post('passc');
        $code = $this->input->post('code');
        $cid = $this->input->post('cid');
        $username = $this->input->post('username');
        log_message('debug','cid ' . $cid);
        if(!$code || !$cid)  redirect(base_url('login'));
        if($pass != $repass) {
            $this->session->set_userdata('last_error', "密码不匹配");
            redirect(base_url('resetpwd/index/' . $code . "/" . $cid));
        }
        $category = $this->user_model->reset_pwd($pass,$code);
        //$category = $this->user_model->reim_update_password($code, $pass, $cid);
        $obj = json_decode($category, True);
        log_message("debug", $category);
        if(0 == $is_newcomer)
        {
            if($obj['status'] > 0){
                if ($active) {
                $jwt = $this->users->my_get_jwt($username, $pass);
//                    $jwt = $this->get_jwt($cid, $pass);
                $this->session->set_userdata('jwt',$jwt);
                    return redirect(base_url('resetpwd/success'));
                } else {
                    return redirect(base_url('login'));
                }

                //$this->load->view('success');
                //
                //$this->session->set_userdata('last_error', "操作成功，请登录");
            } else {
                $this->session->set_userdata('last_error', "操作失败: " . $obj['data']['msg']);
                redirect(base_url('resetpwd/index/' . $code . "/" . $cid));
            }
        }
        else if(1 == $is_newcomer)
        {
            if($obj['status'] > 0){
                
                $jwt = $this->users->my_get_jwt($username, $pass);
//                    $jwt = $this->get_jwt($cid, $pass);
                $this->session->set_userdata('jwt',$jwt);
                return redirect(base_url('install/newcomer'));
            }
            else
            {
                $this->session->set_userdata('last_error','验证信息已经被使用');
                return redirect(base_url());
            }

            //$this->load->view('success');
            //
            //$this->session->set_userdata('last_error', "操作成功，请登录");
        } else {
            $this->session->set_userdata('last_error', "操作失败: " . $obj['data']['msg']);
            redirect(base_url('resetpwd/newcomer/' . $code . "/" . $cid));
        }
    }

    public function success(){
        $this->load->view('success');
    }
}
