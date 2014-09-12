<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ReimAdminHook extends CI_Controller {

    private function startsWith($haystack, $needle) {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    public function check(){
        $uri_string = $this->uri->uri_string();
        if($this->startsWith($uri_string, 'admin') && $uri_string != 'user' && $uri_string != 'login/dologin' && $uri_string != 'login'){
            if(!$this->session->userdata('username')){
                redirect(base_url().'login', 'refresh');
            }
        }
    }
}
