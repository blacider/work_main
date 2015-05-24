<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Pub extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('tags_model', 'tags');
        $this->load->model('group_model', 'groups');
        $this->load->model('user_model', 'users');
        $this->load->model('report_model', 'reports');
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
                if($msg_type == "text") {
                    $msg = $this->response_text("您的消息已经被我们的系统自动接收了", $timestamp, $nonce, $this->wxlib, $from, $to);
                    log_message("debug", "EMSG:" . $msg);
                    die($msg);
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
        $code = $this->input->get('code');
        if(!$code) die("参数错误");
        $this->load->config('reim');
        $appid = $this->config->item('appid');
        $appsec = $this->config->item('appsec');
        #"https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code"
        $uri = sprintf("https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code", $appid, $appsec, $code);
        log_message("debug", "Oauth:" . $uri);
        $buf = $this->do_Get($uri);
        log_message("debug", "Oauth:" . $buf);
        $obj = json_decode($buf, True);
        if(array_key_exists('errcode', $obj)) {
            //TODO: 
        } else {
            $openid  = $obj['openid'];
            $token = $obj['access_token'];
            $unionid = $obj['unionid'];

            $this->session->set_userdata('openid', $openid);
            $this->session->set_userdata('unionid', $unionid);
            $this->session->set_userdata('access_token', $token);

            # 创建帐号
            $user = $this->users->reim_oauth($unionid, $openid, $token);

            if(!$user['status']) {
                // TODO @abjkl, 看看出错了怎么搞
                $this->session->set_userdata('login_error', '用户名或者密码错误');
                redirect(base_url('login'));
                die();
            } else {
                // 展示页面
                //$reim_info = $this->input->get('reim');
                $s = json_decode(base64_decode($params), True);
                //log_message("debug", "$params");
                $nickname = $s['nickname'];
                $gid = $s['gid'];
                $gname = $s['gname'];
                $user_nick = $user['data']['profile']['nickname'];
                die("你好 $user_nick ， 你的好友：$nickname 邀请您加入: $gname, 它的组ID是 $gid");

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
}


