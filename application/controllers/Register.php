<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends REIM_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'users');
        $this->load->model('Register_model');
        $this->load->library('user_agent');
    }

    public function vcode_verify($addr = 'email'){
        if ($addr == 'email') {
            $user_addr = $this->input->post('email');
        } else if($addr == 'phone'){
            $user_addr = $this->input->post('phone');
        }else {
            echo json_encode(array('status' => 1,'msg' => '访问地址错误'));
            return;
        }
        $vcode = $this->input->post('vcode');

        $vcode_verify_back = $this->Register_model->vcode_verify($addr, $user_addr, $vcode);
        $vcode_verify_back['status'] = 1;
        echo json_encode($vcode_verify_back);
        return ;
    }

    public function ok()
    {
        $attacker = $this->agent->agent_string();
        $hasAttacker = false;
        if(stripos($attacker, ';JianKongBao Monitor')) {
            $hasAttacker = true;
        }
        // check ie
        $lte_ie8 = false;
        if ($this->agent->browser() == 'Internet Explorer' and $this->agent->version() <=8) {
            $lte_ie8 = true;
        }

        $this->load->view('user/reg_successful', array(
            'has_attacker'=>$hasAttacker,
            'lte_ie8'=>$lte_ie8
        ));
    }

    public function getvcode($addr = 'email',$scene = 'register'){
        if($addr == 'email')
            $user_addr = $this->input->post('email');
        else if($addr == 'phone')
            $user_addr = $this->input->post('phone');
        else
        {
            echo json_encode(array('status' => 1,'msg' => '访问地址错误'));
            return;
        }

        if(!$user_addr)
        {
            echo json_encode(array('status' => 1,'msg' => '输入手机号或者email'));
            return ;
        }
        if($addr != 'email' && $addr != 'phone')
        {
            $check_user_back = $this->users->check_user($addr,$user_addr);
            if($check_user_back['data']['exists'] == 1)
            {
                echo json_encode(array('status' => 1,'msg' => '账号已被注册'));
                return ;
            }
        }
        $vcode_back = $this->Register_model->getvcode($addr,$user_addr,$scene);
        $vcode_back['status'] = 1;
        echo json_encode($vcode_back);
        return;
    }

    public function company_register(){
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $password = $this->input->post('password');
        $vcode = $this->input->post('vcode');
        $company_name = $this->input->post('company_name');
        $name = $this->input->post('name');
        $position = $this->input->post('position');
        $platform = $this->input->post('platform');
        $reg_from = $this->input->post('reg_from');

        $data = array();
        $data['email'] = $email;
        $data['phone'] = $phone;
        $data['vcode'] = $vcode;
        $data['company_name'] = $company_name;
        $data['password'] = $password;
        $data['name'] = $name;
        $data['position'] = $position;
        $data['platform'] = $platform;
        $data['reg_from'] = $reg_from;

        $check_company_back = $this->users->check_company($company_name);
        if($check_company_back['data']['exists'] == 1)
        {
            echo json_encode([
                'status' => 1,
                'code' => -1,
                'data' => [
                    'msg' => '公司名已被注册'
                ],
            ]);
            return;
        }
        $register_back = $this->Register_model->register($data);
        $register_back['status'] = 1;
        echo json_encode($register_back);
        return ;
    }

}
