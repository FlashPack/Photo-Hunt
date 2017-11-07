<?php
function rand_($num=10,$specialchars=false){
	$randchars=($specialchars===true) ? '0123456789abdefghijklmnopqrstuvwxyzABCDEFJIJKLMONPQRSTUVWXYZ!@#$%^&*': '0123456789abcdefghijklmno';
	for($x=1;$x<=$num;$x++){
		$random.=$randchars[rand(0,strlen($randchars))];
	}
	return $random ;
}

function get_url($var=NULL,$value=NULL){
	if (isset($var)){
		if (isset($_GET[$var]))
			return str_replace("$var=$_GET[$var]","$var=$value",$_SERVER['REQUEST_URI']);
		else
			return strstr($_SERVER['REQUEST_URI'],'?') ? $_SERVER['REQUEST_URI'].'&'.$var.'='.$value :  $_SERVER['REQUEST_URI'].'?'.$var.'='.$value; 
	}else
		return "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}

function test($var){
	echo '<pre>';
	print_r($var);	
	echo '</pre>';
}
function checkEmail($email){
	if(preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $email))
		return true;
	else
	 	return false ; 
}
function getmicrotime($t) {
	list($usec, $sec) = explode(" ",$t);
	return ((float)$usec + (float)$sec);
}

?>