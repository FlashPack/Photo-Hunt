<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
define('PATH',dirname(__FILE__).'/');
require_once(PATH.'/includes/functions.php');
require_once(PATH.'/includes/config.php');

require_once(PATH.'/core/autoloader.class.php');
spl_autoload_register('AutoLoader::autoload');

//Creating Database Object 
$db=MySQL::getInstance(array(config::$dbServer,config::$dbUser, config::$dbPass,config::$dbName));
//Creating Smarty Template Object
AutoLoader::$dir='includes/';
$smarty=new Smarty;

$smarty->compile_check = true;
$smarty->setPluginsDir(config::$smarty_plugins_dir);

$smarty->template_dir=config::$template_dir;
$smarty->compile_dir=config::$template_cache;

$smarty->assign('template_dir',config::$template_dir);
$ajax=isset($_GET['ajax'])?$_GET['ajax']:null;

?>