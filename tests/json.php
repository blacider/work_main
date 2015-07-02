<?php 
	$arr = array('hello' => 'world','java' =>'js','info' => array());
	$json_arr = json_encode($arr);
	$a = json_decode($json_arr);
	if(array_key_exists('hello', $a)){
		echo "hello";
	}
	echo $arr;
	echo "\n";
	echo $json_arr;
	echo json_decode($json_arr);
	foreach(json_decode($json_arr) as $key => $value){
		echo $key."=>".$value."\n";
	};
