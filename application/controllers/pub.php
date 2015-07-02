<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Pub extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('tags_model', 'tags');
        $this->load->model('app_model');
        $this->load->model('group_model', 'groups');
        $this->load->model('user_model', 'users');
        $this->load->model('report_model', 'reports');
        $this->load->library('user_agent');

    }

    public function invite($gid = 0, $uid = 0){
        if(0 === $gid || 0 === $uid){
            die("「参数错误」");
        }


    }


    public function wx(){
        $TOKEN = 'Rushu0915';

        //
        //signature=d0d9c77994e9a86244595dfd3e96d3f4a4e96233
        //timestamp=1432457431
        //nonce=1988866622&
        //encrypt_type=aes&
        //msg_signature=bfb1727cd0bb727ef633a9ff2d2321c0c91e810a
        //
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];  

        $http_method = strtolower($this->input->server('REQUEST_METHOD'));
        if($http_method == "get") {
            $echostr = $_GET["echostr"];  
            $token = $TOKEN;
            $tmpArr = array($token, $timestamp, $nonce);
            sort($tmpArr, SORT_STRING);
            $tmpStr = implode($tmpArr);
            $tmpStr = sha1($tmpStr);
            if( $tmpStr == $signature ){
                die($echostr);
            }else{
                echo "";
            }
        } else {
            $encrypt_type = $this->input->get('encrypt_type');
            $msg_signature = $this->input->get('msg_signature');

            $params = array(
                'token' => $TOKEN
                ,'encodingAesKey' => 'Sw6N3Bb7a7mGbUjpn7w1wc3TK8ZbjlbtVEsvJ89kB5A'
                ,'appId' => 'wx068349d5d3a73855'
            );
            $this->load->library('wxlib', $params);
            $msg = file_get_contents("php://input");

            log_message("debug", "WX Msg: " . $msg);
            log_message("debug", "WX Msg: " . $msg_signature);
            log_message("debug", "WX ts: " . $timestamp);
            log_message("debug", "WX nonce: " . $nonce);
            $sMsg = '';
            $errCode = $this->wxlib->DecryptMsg($msg_signature, $timestamp, $nonce, $msg, $sMsg);
            log_message("debug", "error:" . $errCode);
            //$errCode = $pc->decryptMsg($msg_sign, $timeStamp, $nonce, $from_xml, $msg);
            if ($errCode == 0) {
                log_message("debug", "Get Message From WX:" . $sMsg);
                /*
                 * <xml><ToUserName><![CDATA[gh_3cc13bf56bfa]]></ToUserName>
                 * <FromUserName><![CDATA[oh_4Ttwus34wUuNlDRBbCsEK3rVE]]></FromUserName>
                 * <CreateTime>1432459398</CreateTime>
                 * <MsgType><![CDATA[text]]></MsgType>
                 * <Content><![CDATA[x]]></Content>
                 * <MsgId>6152366267464858206</MsgId>
                 * </xml>
                 */
                $xml_msg = new DOMDocument();
                $xml_msg->loadXML($sMsg);
                $msg_type = $xml_msg->getElementsByTagName('MsgType')->item(0)->nodeValue;
                $from = $xml_msg->getElementsByTagName('FromUserName')->item(0)->nodeValue;
                $to = $xml_msg->getElementsByTagName('ToUserName')->item(0)->nodeValue;
                $content = $xml_msg->getElementsByTagName('Content')->item(0)->nodeValue;
                if($msg_type == "text") {
                    //$result = file_get_contents("http://i.itpk.cn/api.php?question=" . $content);
                    //$msg = $this->response_text($result, $timestamp, $nonce, $this->wxlib, $from, $to);
                    //$msg = $this->response_text("您的消息已经被我们的系统自动接收了", $timestamp, $nonce, $this->wxlib, $from, $to);
                    //log_message("debug", "EMSG:" . $msg);
                    //die($msg);
                    // 用户发来了消息
                } else if ($msg_type == "event") {
                    // 处理关注和取消关注的事情
                    $event_type = $xml_msg->getElementsByTagName('Event')->item(0)->nodeValue;
                    if("subscribe" == $event_type) {
                    $msg = $this->response_text("咦，又一个被报销折磨哭的人关注了我们...", $timestamp, $nonce, $this->wxlib, $from, $to);
                    die($msg);
                    }
                }

                print($errCode . "\n");
            }

        }
    }

    private function response_text($msg, $timeStamp, $nonce, $wxlib, $to, $from){
        $text = sprintf("<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[%s]]></Content></xml>", $to, $from, $timeStamp, $msg);
        log_message("debug", "Return: " . $text);
        return $text;
        $encryptMsg = '';
        $errCode = $wxlib->encryptMsg($text, $timeStamp, $nonce, $encryptMsg);
        if ($errCode == 0) {
            log_message("debug", "Encrypt Success");
            return $encryptMsg;
        } else {
            return "";
        }
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
                $params = urldecode($params);
                // 展示页面
                $s = json_decode(base64_decode($params), True);
                log_message("debug", "GID: $params : " . json_encode($s));
                $nickname = $s['nickname'];
                $gid = $s['gid'];
                $user_nick = $user['data']['profile']['nickname'];
                $user = $user['data']['profile'];
                // * 新人，还没有组，
                if(!$gid)  {
                    // TODO @abjkl, 看看出错了怎么搞
                    $this->session->set_userdata('login_error', '用户名或者密码错误');
                    log_message("debug", "Exists without GID ");
                    //$this->load->view('wx/apply', array('gname' => $gname, 'invitor' => $nickname, 'gid' => $gid, 'uid' => $user['id']));
                    //redirect(base_url('login'));
                    $gname = '';
                    $msg = '';
                    $this->load->view('wx/success', array('msg' => $msg, 'gname' => $gname));
                    die();
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
                   // redirect(base_url('install/wx/').'?'.'gname='.$gname);
                   /* if ($this->agent->is_mobile('iphone'))
                        {
                            $this->load->view('wx/iphone',array('gname' => $gname, 'invitor' => $nickname, 'gid' => $gid, 'uid' => $user['id']));
                        }
                        else if ($this->agent->is_mobile())
                        {
                            $this->load->view('wx/adroid',array('gname' => $gname, 'invitor' => $nickname, 'gid' => $gid, 'uid' => $user['id']));
                        }
                        else
                        {
                            $this->load->view('wx/index',array('gname' => $gname, 'invitor' => $nickname, 'gid' => $gid, 'uid' => $user['id']));
                        }*/
                }
            }
        }
    }

    public function d(){
        $this->load->config('reim');
        $appid = $this->config->item('appid');
        $appsec = $this->config->item('appsec');
        $params = base64_encode(json_encode(array('nickname' => '老杨', 'gid' => '123', 'gname' => '我家娃还没起CODENAME')));
        $ruri = urlencode(base_url('pub/oauth/' . $params));
        $scope = 'snsapi_userinfo';
        $uri = sprintf('https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=%s&state=reim_debug#wechat_redirect', $appid, $ruri, $scope);
        echo $uri;
    }

    public function dojoin(){
        $name = $this->input->post('name');
        $gid = $this->input->post('gid');
        $uid = $this->input->post('uid');
        if(!$uid) die(json_encode(array('status' => false, 'msg' => '参数错误')));
        if(!$gid) die(json_encode(array('status' => false, 'msg' => '参数错误')));
        if(!$name) die(json_encode(array('status' => false, 'msg' => '参数错误')));

        // 修改昵称
        $info = $this->users->reim_update_profile("", "", $name, "");

        $info = json_decode($info, True);
        if(!$info['status']) die(json_encode(array('status' => false, 'msg' => '修改参数失败')));
        // 提交申请
        $info = $this->users->doapply($gid);

        redirect(base_url('pub/success/' . $name));

    }

    public function success($gname = ''){
            log_message("debug", "----------- ***************** ------> Not Micro :" );
        $msg = '';
        //$this->load->view('wx/success', array('msg' => $gname, 'gname' => $gname));
       redirect(base_url('install'));
    }

    public function version(){
        $info = $this->app_model->find_all_online();
        die(json_encode($info));
    }


}






