<?php
$username=input::post('username');
$username=input::post('name');
$password=md5(md5($_POST['password']));
$email=input::post('email');
$usernameQuery=$db->query("select usr_id from user where usr_username='$username' ",true,true);
if($usernameQuery['count']>=1){
	$alerts[]='This username is already taken';
	$error=true;
}
if(!checkEmail($email)){
	$alerts[]='The email is in invalid';
	$error=true;
}

$emailQuery=$db->query("select usr_id from user where usr_email='$email' ",true,true);
if($emailQuery['count']>=1){
	$alerts[]='This email is already registered';
	$error=true;
}
if(!$error){
	$ip=$_SERVER['REMOTE_ADDR'];
	$db->query("insert into user (usr_name,usr_username,usr_password,usr_email,usr_ip,usr_registerdate) values('$username','$username','$password','$email','$ip',unix_timestamp())",false);
	$usr_id=mysqli_insert_id($db->dbLink);
	$db->query("insert into user_score (usr_id,total_score) values('$usr_id',0)",false);
	$_SESSION['user_logged']=true; 
	$_SESSION['user_id']=$usr_id; 
	echo '<META HTTP-EQUIV="refresh" CONTENT="0;URL=index.php?view=play">';
}else{
	$smarty->assign('_POST',$_POST);
	$smarty->assign('alerts',$alerts);
}
?>