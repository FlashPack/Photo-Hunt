<?
$startTime=microtime();

require_once('includes/functions.php');
require_once('includes/config.php');

require_once('libraries/smarty/Smarty.class.php');

$db=new mysql;
$db->connect(config::$dbServer,config::$dbUser, config::$dbPass);
$db->select_db(config::$dbName);

framework::inilaize();

if(config::$debug){
	$endTime= microtime();
	$t2 = round((getmicrotime($endTime) - getmicrotime($startTime)),3); 
	'<div class="debug">Time of Execution : <b>'.$t2.'</b></div>';
}
$db->query("replace into sessions (session_id,data,last_access,ip) values('".session_id()."','".$_SERVER['HTTP_USER_AGENT']."',unix_timestamp(),'".$ip."')",false);
?>