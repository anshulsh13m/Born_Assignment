<?php 
	$a = '1'; //(value string 1 will be stored to variable $a)
	$b = &$a; // ($b and $a is pointing to same address content, i.e. will contain same value and $b will store string 1)
	$b = "2$b"; //($b will be stored by string 21 and same value will be stored to $a because of passing by reference a second step
	echo $a. ", ".$b; // Output is 21, 21)
	
?>