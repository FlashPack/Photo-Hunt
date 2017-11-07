<?php
class users{
	function __construct(){} 
	public function dispatch(){
		if(is_callable(array($this,$_GET['action']))){
			$this->$_GET['action']();
		}elseif(is_callable(array($this,$_POST['action']))){
			$this->$_POST['action']();
		}else{
			$this->Main();
		}
	}
	public function Main(){
		global $db,$smarty;
		$users=$db->query("select user.*,user_score.total_score,user_score.played_levels from user left join user_score on user.usr_id=user_score.usr_id order by total_score desc ",true,true,15);
		$smarty->assign('users',$users['rows']);
		$smarty->assign('pages',$users['nav']['string']);
		$smarty->display('users/users.html');
	}
	public function delete(){
		global $db;
		$usr_id=input::post('usr_id');
		test($_POST);
		$db->query("delete from user where usr_id='$usr_id'",false);
		$db->query("delete from user_score where usr_id='$usr_id'",false);
	}
	public function delete_selected(){
		global $db;
		$usr_ids=$_POST['usr_ids'];
		foreach($usr_ids as $usr_id){
			$db->query("delete from user where usr_id='$usr_id'",false);
			$db->query("delete from user_score where usr_id='$usr_id'",false);
		}
		$this->Main();
	}
}
?>