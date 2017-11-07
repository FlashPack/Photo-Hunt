<?php
if($_POST['register']){
	include('register.php');
}
$smarty->display('login.html');
?>