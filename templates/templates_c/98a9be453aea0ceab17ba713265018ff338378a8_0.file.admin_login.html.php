<?php
/* Smarty version 3.1.30, created on 2017-11-07 22:44:07
  from "C:\xampp\htdocs\photo_hunt\templates\admin\admin_login.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a02292764bc48_89368685',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '98a9be453aea0ceab17ba713265018ff338378a8' => 
    array (
      0 => 'C:\\xampp\\htdocs\\photo_hunt\\templates\\admin\\admin_login.html',
      1 => 1280442508,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a02292764bc48_89368685 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_block_alerts')) require_once 'C:\\xampp\\htdocs\\photo_hunt\\includes\\smarty_plugins\\block.alerts.php';
?>
<table align="center" width="50%"><tr><td>
<form method="post"  >
<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('alerts', array());
$_block_repeat1=true;
echo smarty_block_alerts(array(), null, $_smarty_tpl, $_block_repeat1);
while ($_block_repeat1) {
ob_start();
$_block_repeat1=false;
echo smarty_block_alerts(array(), ob_get_clean(), $_smarty_tpl, $_block_repeat1);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" >
  <tr>
    <th scope="col" width="29%" ><div align="left" class="label">Username :</div></th>
	<td width="71%" scope="col" ><div align="left" ><span class="font">
      <input type="text" name="username" class="inputtext" id="textfield" size="20" value="<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
" />
    </span></div></td>
  </tr>
  <tr>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
  </tr>
  <tr>
       <th scope="col"><div align="left" class="label">Password :</div></th>
	   <td scope="col"><div align="left"><span class="font">
         <input type="password" name="password" class="inputtext" id="password" size="20" />
      </span></div></td>
  </tr>
  <tr>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
  </tr>
  <tr>
    <td colspan="2">
      <div  align="left">
        </div></td>
    </tr>
</table>
<center> <input type="submit" name="login"  value="Login" class="button"/></center>
</form>
</td></tr></table>

<?php echo '<script'; ?>
 type="text/javascript">
$(function(){
	
	<?php if ($_smarty_tpl->tpl_vars['alert']->value) {?>
		$('.alert').show();
	<?php }?>
	
});
<?php echo '</script'; ?>
>

<?php }
}
