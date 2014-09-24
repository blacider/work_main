<?php

class Reim_Model extends CI_Model {
    public function do_Post($url, $fields, $extraheader = array()){
        $ch  = curl_init() ;
        curl_setopt($ch , CURLOPT_URL, $url ) ;
        curl_setopt($ch , CURLOPT_POST, count ( $fields )) ;
        curl_setopt($ch , CURLOPT_POSTFIELDS, $fields );
        curl_setopt($ch,CURLOPT_HTTPHEADER, $extraheader);
        curl_setopt($ch, CURLOPT_VERBOSE, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        ob_start();
        curl_exec($ch );
        $result  = ob_get_contents() ;
        ob_end_clean();
        curl_close($ch ) ;
        return $result;
    }

    public function do_Get($url, $extraheader = array()){

        $ch = curl_init();
        curl_setopt($ch , CURLOPT_URL, $url ) ;
        curl_setopt($ch,CURLOPT_HTTPHEADER, $extraheader);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        curl_setopt($ch, CURLOPT_VERBOSE, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        $output = curl_exec($ch) ;
        curl_close($ch);
        return $output;
    }

    public function do_Put($url, $fields, $extraheader = array()){
        $ch  = curl_init() ;
        curl_setopt($ch , CURLOPT_URL, $url ) ;
        curl_setopt($ch , CURLOPT_POST, count ( $fields )) ;
        curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch , CURLOPT_POSTFIELDS, $fields );
        curl_setopt($ch,CURLOPT_HTTPHEADER, $extraheader);
        curl_setopt($ch, CURLOPT_VERBOSE, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        ob_start();
        curl_exec($ch );
        $result  = ob_get_contents() ;
        ob_end_clean();
        curl_close($ch ) ;
        return $result;
    }

    public function do_Delete($url, $fields, $extraheader = array()){
        $ch  = curl_init() ;
        curl_setopt($ch , CURLOPT_URL, $url ) ;
        curl_setopt($ch , CURLOPT_POST, count ($fields)) ;
        curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch , CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch,CURLOPT_HTTPHEADER, $extraheader);
        curl_setopt($ch, CURLOPT_VERBOSE, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
        ob_start();
        curl_exec($ch );
        $result  = ob_get_contents() ;
        ob_end_clean();
        curl_close($ch ) ;
        return $result;
    }
}

