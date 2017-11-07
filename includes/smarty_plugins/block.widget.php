<?php
function smarty_block_widget($params,$content,$smarty,$open){
	if(!$open){
		$smarty->assign('params',$params);
		$smarty->assign('content',$content);
		
		$smarty->display('gadgets/widget.html');
	}
}
?>