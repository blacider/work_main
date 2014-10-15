<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class REIM_Controller extends CI_Controller{
    private function startsWith($haystack, $needle)
    {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }


    public function __construct(){
        parent::__construct();
        if($this->session->userdata('jwt') == ""){
            $uri = $this->uri->uri_string();
            $flag = 1;
            $prefixs = array('login', 'register');
            foreach($prefixs as $prefix){
                if($this->startsWith($uri, $prefix)){
                    $flag = 0;
                }
            }
            if($flag) redirect(base_url('login'));
        }
    }

    public function  eload($view_name, $custom_data){
        $profile = $this->session->userdata('profile');
        if(!$profile) redirect(base_url('login'));
        $menu =  $this->load->view('menu', $custom_data, True);
        $body =  $this->load->view($view_name, $custom_data, True);
        $custom_data['menu'] = $menu;
        $custom_data['body'] = $body;
        $custom_data['profile'] = $profile;
        $this->load->view('template', $custom_data);

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
}
