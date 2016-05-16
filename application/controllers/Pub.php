<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pub extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('app_model');
        $this->load->library('user_agent');

    }

    public function version(){
        $info = $this->app_model->find_all_online();
        foreach($info as &$i){
            if($i['platform'] == 0) {
                $i['path'] = 'https://itunes.apple.com/cn/app/yun-bao-xiao-dui-bao-xiao/id1030689407';
            } else {
                $i['path'] = "http://d.yunbaoxiao.com/android/" . $i['version'] . "/reim.apk";
            }
            log_message("debug", json_encode($i));
        }
        die(json_encode($info));
    }

    public function xreim(){
        $info = $this->app_model->find_online(0);
        $url = "http://d.yunbaoxiao.com/iOS/{$info['version']}/reim.ipa";
        return $this->ipa_plist($url);
    }

    public function ios_pkg() {
        $pkg = $this->input->get('p');
        if (empty($pkg)) {
            show_404();
        }
        $pkg = urlencode($pkg);
        $plist_url = "https://www.yunbaoxiao.com/pub/ipa/$pkg/";
        $this->load->view('pub/ios_pkg',
            ['plist_url' => $plist_url,]
        );
    }

    public function ipa($pkg){
        if (strpos($pkg, '.ipa') === false) {
            $pkg .= '.ipa';
        }
        $pkg_path = dirname(APPPATH) . "/static/pkg/$pkg";
        if (!file_exists($pkg_path)) {
            show_404();
        }
        $url = "https://admin.cloudbaoxiao.com/static/pkg/$pkg";
        return $this->ipa_plist($url);
    }

    private function ipa_plist($url) {
        $file_path = APPPATH . "/views/pub/plist";
        $buf = file_get_contents($file_path);
        $content = str_replace("__URL__", htmlspecialchars($url, ENT_XML1), $buf);
        die($content);
    }

}






