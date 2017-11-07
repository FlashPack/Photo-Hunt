<?php
class admin_session {
	function check(){
		global $db;
		if ($_SESSION['admin_logged']!=true){
			return $this->login();
		}else{
			return true;
		}
	}
	function access_denied()
	{
		$this->alert='Access is denied';
		return false ;
	}
	function login(){
		global $db ; 
		if(isset($_POST['login'])){
			$username=input::post('username');
			$password=md5(md5($_POST['password']));
			$select=$db->query("select admin_id from admin where admin_username='$username' && admin_password='$password'");
			if(mysqli_affected_rows($db->dbLink)>=1){
				$_SESSION['admin_logged']  = true;
				$_SESSION['admin_id']  = $select['rows'][0]['admin_id'];
				echo '<META HTTP-EQUIV="refresh" CONTENT="1;URL='.$_SERVER['REQUEST_URI'].'">';
				return true;
			}else{
				$this->alert='Username and/or password are incorrect';
			}
		}
		return false;  
	}
	function logout(){
		$_SESSION['admin_logged']=false;
		$_SESSION['admin_id']=NULL;
		session_destroy();
		echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.php">';
	}	
	
}
?>