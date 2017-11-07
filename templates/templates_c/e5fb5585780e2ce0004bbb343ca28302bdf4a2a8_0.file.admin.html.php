<?php
/* Smarty version 3.1.30, created on 2017-11-07 22:45:17
  from "C:\xampp\htdocs\photo_hunt\templates\admin\admin.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a02296dedb502_21632319',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e5fb5585780e2ce0004bbb343ca28302bdf4a2a8' => 
    array (
      0 => 'C:\\xampp\\htdocs\\photo_hunt\\templates\\admin\\admin.html',
      1 => 1314804374,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a02296dedb502_21632319 (Smarty_Internal_Template $_smarty_tpl) {
?>
<center>
<table width="50%" border="0">
<tr>
	<td><a href="admin.php?view=categories"><img src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
/images/categories.png" border="0"><br>Categories</a></td>
	<td><a href="admin.php?view=levels"><img src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
/images/levels.png" border="0"><br>Levels</a></td>
	<td><a href="admin.php?view=users"><img src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
/images/users.png" border="0"><br>Users</a></td>
</tr>
<tr>
	<td><a href="admin.php?view=settings"><img src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
/images/settings.png" border="0"><br>Settings</a></td>
	<td><a href="admin.php?view=bgmusic"><img src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
/images/sound-icon.png" width="64" height="64" border="0"><br>Background Music</a></td>
	<td><a href="admin.php?view=logout"><img src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
/images/logout.png" border="0"><br>Logout</a></td>

</tr>
</table>
</center><?php }
}
