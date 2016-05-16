<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Pub extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('app_model');
        $this->load->model('group_model', 'groups');
        $this->load->model('user_model', 'users');
        $this->load->library('user_agent');

    }

    public function oauth($params = ''){
        log_message("debug", "Agent:" . strtolower($this->input->user_agent()));
        if(strpos(strtolower($this->input->user_agent()), 'micromessenger') === FALSE ) {
            log_message("debug", "----------- ***************** ------> Not Micro Group:" );
            redirect(base_url('pub/success/'));
        }
        $code = $this->input->get('code');
        if(!$code) die("参数错误");
        $this->load->config('reim');
        $appid = $this->config->item('appid');
        $appsec = $this->config->item('appsec');
        $uri = sprintf("https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code", $appid, $appsec, $code);
        log_message("debug", "Oauth:" . $params);
        $buf = $this->do_Get($uri);
        log_message("debug", "Oauth:" . $buf);
        $obj = json_decode($buf, True);
        if(array_key_exists('errcode', $obj)) {
            //TODO: 
                $this->session->set_userdata('login_error', '用户名或者密码错误');
                redirect(base_url('login'));
        } else {
            $openid  = $obj['openid'];
            $token = $obj['access_token'];
            $unionid = $obj['unionid'];

            $this->session->set_userdata('openid', $openid);
            $this->session->set_userdata('unionid', $unionid);
            $this->session->set_userdata('access_token', $token);

            $check = 0;
            # 创建帐号
            $user = $this->users->reim_oauth($unionid, $openid, $token, $check);
            log_message("debug", "REIM OAUTH:" . json_encode($user));
            if(!$user['status']) {
                // TODO @abjkl, 看看出错了怎么搞
                log_message("debug", "Redirect to Login without status");
                $this->session->set_userdata('login_error', '用户名或者密码错误');
                redirect(base_url('login'));
                die();
            } else {
                // 展示页面
                $s = json_decode(base64_decode($params), True);
                log_message("debug", "GID: $params : " . json_encode($s));
                $nickname = $s['nickname'];
                $gid = $s['gid'];
                $user_nick = $user['data']['profile']['nickname'];
                $user = $user['data']['profile'];
                // * 新人，还没有组，
                if(!$gid)  {
                    $params = urldecode($params);
                    $s = json_decode(base64_decode($params), True);
                    log_message("debug", "GID: $params : " . json_encode($s));
                    $nickname = $s['nickname'];
                    $gid = $s['gid'];
                    //$user_nick = $user['data']['profile']['nickname'];
                    //$user = $user['data']['profile'];
                    if(!$gid) {
                        // TODO @abjkl, 看看出错了怎么搞
                        $this->session->set_userdata('login_error', '用户名或者密码错误');
                        log_message("debug", "Exists without GID ");
                        $gname = '';
                        $msg = '';
                        $this->load->view('wx/success', array('msg' => $msg, 'gname' => $gname));
                        die();
                    }
                }
                log_message("debug", "GID:" . $gid);
                $_group = $this->groups->get_by_id($gid);
                if(!$_group['status']){
                    $this->session->set_userdata('login_error', '用户名或者密码错误');
                    redirect(base_url('login'));
                    die();
                }
                $_group = $_group['data']['ginfo'];

                log_message("debug", "$gid Group:" . json_encode($_group));
                log_message("debug", "$gid Group:" . json_encode($user));

                $gname = '';
                $__group = array();
                if($_group) {
                    //$__group = json_decode($_group, True);
                    if(array_key_exists('group_name', $_group)) {
                        $gname = $_group['group_name'];
                    }
                }
                if($user['gid'] == $gid) {
                    log_message("debug", "------> Same Group:" );
                    $msg = $gname;
                    $this->load->view('wx/success', array('msg' => $msg, 'gname' => $gname));
                    //redirect(base_url('install'));
                } else {
                    log_message("debug", "------> Same Group:" );
                    $this->load->view('wx/apply', array('gname' => $gname, 'invitor' => $nickname, 'gid' => $gid, 'uid' => $user['id']));
                }
            }
        }
    }

    public function success($gname = ''){
        log_message("debug", "----------- ***************** ------> Not Micro :" );
        $msg = '';
        redirect(base_url('install'));
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
        $plist_url = "https://admin.cloudbaoxiao.com/pub/ipa/$pkg/";
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






