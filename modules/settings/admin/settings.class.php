<?php
class settings{
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
		if($_POST['submit']!='admin'){
			$_POST=array_reverse($_POST); 
			array_shift($_POST);
			array_shift($_POST);
			foreach($_POST as $st_name=>$st_value){
				$db->query("update settings set st_value='$st_value' where st_name='$st_name'",$value);
			}
		}else{
			$username=input::post('username');
			$current_password=$_POST['current_password'];
			$new_password=$_POST['new_password'];
			$confirm_password=$_POST['confirm_password'];
			
			if($current_password && $new_password && $confirm_password){
				$current_password=md5(md5($current_password));
				$db->query("select * from admin where admin_id='".$_SESSION['admin_id']."' && admin_password='$current_password'");
				if(mysql_affected_rows()==1){
					$new_password=md5(md5(input::post('new_password')));
					$db->query("update admin set admin_password='$new_password',admin_username='$username' where admin_id='".$_SESSION['admin_id']."' ",false);
				}else{
					$smarty->assign('alerts','The current password is incorrect');
				}
			}else{
				$db->query("update admin set admin_username='$username' where admin_id='".$_SESSION['admin_id']."' ",false);
			}
		}
		$admin=$db->query("select admin_username from admin where admin_id='".$_SESSION['admin_id']."'");
		$smarty->assign('admin',$admin['rows'][0]);
		$settings=self::get_settings($query);
		$smarty->assign('settings',$settings);
		$smarty->display('settings/settings.html');
	}
	public static function sort_settings($settings){
		if(is_array($settings)){
			for($i=0;$i<$settings['count'];$i++){
				$_settings[$settings['rows'][$i]['st_group']][$settings['rows'][$i]['st_name']]=$settings['rows'][$i]['st_value'];
			}
			return $_settings; 
		}
		return false;
	}
	public static function get_settings($group=NULL){
		global $db ; 
		if($group){
			$query=$db->query("select * from settings where st_group='$group'",true,true);
		}else{
			$query=$db->query("select * from settings",true,true);
		}
		return self::sort_settings($query);
	}
}
?>