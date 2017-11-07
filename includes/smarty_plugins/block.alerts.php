<?php
function smarty_block_alerts($params,$content,$smarty,$open){
	if(!$open){
		$smarty->assign('params',$params);
		$template_dir=$smarty->template_dir;
		$smarty->template_dir=config::$template_dir;
		$smarty->display('alerts.html');
	}
}
?>