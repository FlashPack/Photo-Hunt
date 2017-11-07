<?php
class dispatcher{
	function __construct(){}
	public  function dispatch($arg=NULL){
		global $db,$smarty;
		$request=input::get('view');
		if($arg=='admin'){
			$session=new admin_session;
			if($session->check()){
				if(in_array($request,config::$backend_whitelist)){
					include('modules/'.$request.'/admin/index.php');
				}elseif($request=='logout'){
					$session->logout();
				}elseif(isset($request)){
					include('modules/admin/index.php');
				}
			}else{
				$smarty->assign('alerts',$session->alert);
				$smarty->display('admin_login.html');
			}
		}else{
			include('modules/frontend/index.php');
		}
	}
}
?>