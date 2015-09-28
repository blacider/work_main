<?php

class Reim_Cipher{
	private $securekey, $iv;
	private $key_string;
 	//    private $db;
 	public function __construct(){
		$this->key_string = array(
			'Q', 'A', 'Z', 
			'W', 'S', 'X', 
			'E', 'D', 'C', 
			'R', 'F', 'V', 
			'T', 'G', 'B', 
			'Y', 'H', 'N', 
			'U', 'J', 'M', 
			'I', 'K', 'O',
			'L', 'P',
			'q', 
			'w', 'e', 'r', 't', 
			'y', 'u', 'i', 'o', 
			'p', 'a', 's', 'd', 
			'f', 'g', 'h', 'j', 
			'k', 'l', 'z', 'x', 
			'c', 'v', 'b', 'n', 
			'm',
			'8', '3', '1', '2', '9',
			'0', '5', '4', '6', '7'
		);
 	}

	public function encode($input) {
		$enc = base64_encode($input);
		$ret = '';
		
		for($i=0; $i<strlen($enc); $i++) {
			$value = ord(substr($enc, $i, 1));
			if($value>=65 && $value<=90) {
				$ret = $ret.$this->key_string[$value-65];
			}
			else if($value>=97 && $value<=122) {
				$ret = $ret.$this->key_string[$value-97+26];
			}
			else if($value>=48 && $value<=57) {
				$ret = $ret.$this->key_string[$value-48+52];
			}
			else if($value===43) {
				$ret = $ret.'.';
			}
			else if($value===47) {
				$ret = $ret.'_';
			}
			else if($value===61) {
				$ret = $ret.'-';
			}
		}
		return $ret;
	}

	public function decode($input) {
		$decode = '';
		for($i=0; $i<strlen($input); $i++) {
			$value = ord(substr($input, $i, 1));
			$j = 0;
			for($j=0; $j<count($this->key_string); $j++) {
				if(ord($this->key_string[$j]) === $value)
					break;
			}
		
			if($j<26) {
				$decode = $decode.chr($j+65);
			}
			else if($j<52) {
				$decode = $decode.chr($j-26+97);
			}
			else if($j<62) {
				$decode = $decode.chr($j-52+48);
			}
			else {
				if($value === '.') {
					$decode = $decode.'+';
				}
				else if($value === '_') {
					$decode = $decode.'/';
				}
				else {
					$decode = $decode.'=';
				}
			}
		}
		$decode = base64_decode($decode);
		return $decode;
	}
}
$s = new Reim_Cipher();
$a = $s->encode('helloworld');
$s->decode($a);

