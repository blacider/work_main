<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Pub extends REIM_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('tags_model', 'tags');
        $this->load->model('group_model', 'groups');
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

    public function s(){
        $msg = '<xml> <ToUserName><![CDATA[gh_3cc13bf56bfa]]></ToUserName> <Encrypt><![CDATA[bWKhCYduzT+3lE9v++eWnBQoJBX7dKOwKC6tJoBbMtHG5T5IQS5IFJN/OaZ75+Gdtuo8H2GUWnY3z/U5l1eX6vMhc8XjRZL0RQNAsIwySq9/eBp090wktyummGMbb1+bkhE+FSencMQYHneb37OzESNzBptAsL22B9XeVihbRW+2W8tdEWbBArtfg0pEjHMwk2cyrOaXUiSCQDH1bVmmCpYKy3+LNCHxwE6Oc25zwdKU8yiATas0XGO4jOu88NL8RBF2j9XmxpsyxC03pHC2Bdmkf0fzxokQ+ORK9jOgZtsNtiW4D05VSH6gqlLtkdBec/obYBWq08DD/ELXH7Aa+rkj52xtpdwKLl7wakfMU1ZCCwVWFm2+udBwhjknftQiIPB8scvRUTobeSwGRcLMEH353owy1SYzMZV6AcYTU1I=]]></Encrypt> </xml>';

        $msg = '<xml>
                <ToUserName><![CDATA[gh_3cc13bf56bfa]]></ToUserName>
                    <Encrypt><![CDATA[kCSccM/CIHl9TvFdEVl8s4dhaA1nsGc7p0Ujoon0vbB7s1ArpCkky7KgKkr2m8A8u2D6rJtJl39Q/qyOACoottk8XJdXU23eR3Rma/Ko5UYxQs4fEaId9T7vMpihNsHB7pYSC5DWliLmUx0mDYagNCPRSJyXBBfyOTKYShmKatfYl8lKBx8H1nebUyae7zhRRtLRgWPKNCNhkr/ZBzb8aPXLDsJfk30qDcXlA4dsBq0T7xOTcqEZbGqqZU5IXIRt5lkafuC1L/UdxipawBC5uHeuQ+MhKD8g6ER1TmuFsKGxkcw/s4YtHsg7mOH2ehi1KS4bkUnVOyb73fdFDeJwrT/3JPxR8XTk9yiKscdHArsM0Jw1HEdAlEDSmGAl6X2TzKHnkHHsQlLuUvdzntgDzXcab/h7FzmlKV36ddaiJAg=]]></Encrypt>
                    </xml>';

        $msg = '<xml>
                <ToUserName><![CDATA[gh_3cc13bf56bfa]]></ToUserName>
                    <Encrypt><![CDATA[kcXz21tppMjZnFob24Sguzv7EeqfyUohja83FU2vQJeZsIMcE4qJuwBMSSZIfeI7OmegZKmwyEkoVxC/4+I5LCDCZVfw+TK0HvwSxJg7U3MMhIhjltoAyy961Mj8ypJal1mmHuT/BScqC6cjpW7n8RRZ+immsKyRQbFBA1fEIrJITy1lSOVHSGIOC3x3RFxsI1KLtYtRuVYZjGkyKbcvRWpbJ5iO0Qnf6oyeHsoxowki8+f1VL/jIXeamu3P6fGe/APY3vHzqsR8u5Hy/TzDop02hXqPbh8odk5+H+o4kGmC9YEc20NC8wQ+o38Zu5lEsfb73NkPwIVZF9AF1Rde3oLa+rn69eH97rFWrIZZWZ1dt6aLF+wXsMeKy2TI0FNxZfPKRHArHZjwp1iEoK9z/cYKxxKf6udDMsCPOsRkwbk=]]></Encrypt>
                    </xml>';

        $TOKEN = 'Rushu0915';
            $params = array(
                'token' => $TOKEN
                ,'encodingAesKey' => 'Sw6N3Bb7a7mGbUjpn7w1wc3TK8ZbjlbtVEsvJ89kB5A'
                ,'appId' => 'wx068349d5d3a73855'
            );
            $this->load->library('wxlib', $params);
            $sMsg = '';
            $signature = '529ee9ab0b037418b23f886f89a52120f953965b';
            $timestamp =  '1432459323';
            $nonce =  '1260402563';
            print_r($msg);
            $xml_tree = new DOMDocument();
            $xml_tree->loadXML($msg);
            $array_e = $xml_tree->getElementsByTagName('Encrypt');
            //$array_s = $xml_tree->getElementsByTagName('MsgSignature');
            $encrypt = $array_e->item(0)->nodeValue;
            //$msg_sign = $array_s->item(0)->nodeValue;
            $errCode = $this->wxlib->DecryptMsg($signature, $timestamp, $nonce, $msg, $sMsg);

            echo $errCode;
    }
}


