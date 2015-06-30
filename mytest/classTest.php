
<?php 
class A{
	function foo(){
		if(isset($this)){
			echo "this is defined ,it's ".get_class($this);
			}
		else
		{
			echo "this is not defined!";
		}
		}
	}
class B{
	function bar(){
		A::foo();	
	}
}

$a = new A();
$a->foo();

A::foo();
$b = new B();
$b->bar();

B::bar();
