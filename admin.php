<?php
require_once('globals.php');

$smarty->template_dir=config::$template_dir.'admin/';
$dispatcher=new dispatcher; 
if(!$ajax)$smarty->display('admin_header.html');
$dispatcher->dispatch('admin');
//$smarty->template_dir.=$smarty->template_dir==config::$template_dir?'admin/':'';
$smarty->template_dir=config::$template_dir.'admin/';

if(!$ajax)$smarty->display('admin_footer.html');

?>