<?php
class input{
	private $instance = NULL ; 
	public function getInstance(){
		if(self::$instance===NULL){
			self::$instance=new self;
		}
		return self::$instance ; 
	}
	public static function get($var){
		if(!isset($_GET[$var])){
			return $var ; 
		}
		return htmlspecialchars(stripslashes(trim($_GET[$var])));
	}
	public static function post($var){
		if(!isset($_POST[$var])){
			return $var ; 
		}
		return htmlspecialchars(stripslashes(trim($_POST[$var]))) ; 
	}

}
?>