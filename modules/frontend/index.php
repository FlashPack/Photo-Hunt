<?php
$view=input::get('view');
if($view!='play'){
	//$smarty->assign('logged',$_SESSION['user_logged']);
	$img_width=$db->query("select st_value from settings where st_name='image_width'");
	$smarty->assign('image_width',$img_width['rows'][0]['st_value']);
	$smarty->display('header.html');
}
$session=new user_session;
switch($view){
case 'play':
	include('modules/levels/start.php');
	break;
		
break;
case 'logout':
	$session->logout();
break;
default:
	include('modules/categories/index.php');
break;
}

if($view!='play'){
	$smarty->display('footer.html');
}
?>