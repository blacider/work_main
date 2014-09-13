<?php
require_once('transfer.php');
define("PREFIX", "http://localhost/");
/* define("PREFIX", "http://api.1in1.cn/reim_dev/v1/");*/
//require_once('../application/libraries/JWT.php');
define("PUBKEY", "1NDgzZGY1OWViOWRmNjI5ZT");
define("USER_EMAIL", 'debug@rushucloud.com');
define("USER_PASSWORD", 'debugabc123');
define("USER_NEW_PASSWORD", 'debugabc123');

class API extends PHPUnit_Framework_TestCase {

    private function randomkeys($length)
    {
        $output='';
        for ($a = 0; $a < $length; $a++) {
            $output .= chr(mt_rand(97, 122));    //生成php随机数
        }
        return $output;
    }


    private function debug($msg){
        echo __FUNCTION__ . "$msg";
    }

    private function get_header($config){
        return array();
        //return array('X-REIM-JWT: ' . JWT::encode($config, PUBKEY));
    }

    public function testregister(){
        for($i = 0; $i < 1000; $i++){
            $data  = array('type' => rand(1, 10), 'host' => '127.0.0.1', 'message' => 'for develop', 'level' => rand(1, 5));
            $url = PREFIX . "/logs/async";
            $buf = do_Post($url, $data, $this->get_header($data));
            print $buf;
            $obj = json_decode($buf, true);
        }
        return $this->assertTrue($obj['status']);
    }


}
