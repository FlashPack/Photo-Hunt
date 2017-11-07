<?php
class user_session {
	function check(){
		global $db;
		if ($_SESSION['user_logged']!=true){
			return $this->login();
		}else{
			return true;
		}
	}
	function login(){
		global $db ; 
		if(isset($_POST['login'])){
			$username=input::post('username');
			$password=md5(md5($_POST['password']));
			$select=$db->query("select usr_id from user where usr_username='$username' && usr_password='$password'");
			if(mysqli_affected_rows($db->dbLink)>=1){
				$_SESSION['user_logged']  = true;
				$_SESSION['user_id']  = $select['rows'][0]['usr_id'];
				echo '<META HTTP-EQUIV="refresh" CONTENT="1;URL='.$_SERVER['REQUEST_URI'].'">';
				return true;
			}else{
				$this->alert='Username and/or password are incorrect';
			}
		}
		return false;  
	}
	function logout(){
		$_SESSION['user_logged']=false;
		$_SESSION['user_id']=NULL;
		session_destroy();
		echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.php">';
	}	
}
?>