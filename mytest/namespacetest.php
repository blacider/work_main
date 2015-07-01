<?php 
	class Myclass{
	    public $var1 = 'value 1';
	    public $var2 = 'value 2';
	    public $var3 = 'value 3';
	   protected $protect = 'protected value'; 
	   private $priavate = 'private value';

	   public function isVisible(){
	  	foreach($this as $key => $value){
			echo "$key => $value";
		}; 
	   }
	}
	
	$class = new Myclass();
	foreach($class as $key => $value){
		echo "$key => $value\n";
	}
	$class -> isVisible();
?>
