<?php
/* Smarty version 3.1.30, created on 2017-11-07 22:05:10
  from "C:\xampp\htdocs\photo_hunt\templates\game\categories.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a022006441975_43299595',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ed434ac5f1126e9b19784c5f6c5056857400891e' => 
    array (
      0 => 'C:\\xampp\\htdocs\\photo_hunt\\templates\\game\\categories.html',
      1 => 1510088709,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a022006441975_43299595 (Smarty_Internal_Template $_smarty_tpl) {
?>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
css/play.css" media="all" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
css/style.css" media="all" />
<?php echo '<script'; ?>
 type="text/javascript" src="js/jquery-1.4.2.min.js"><?php echo '</script'; ?>
>


<?php echo '<script'; ?>
 type="text/javascript">
$(function(){
	$('.category a').click(function(){
		width=Number(<?php echo $_smarty_tpl->tpl_vars['image_width']->value;?>
*2+100);
		window.open('?view=play&cat_id='+$(this).attr('rel')+'', "play_window","location=0,resizable=0,status=0,scrollbars=1,width="+width+",height=700");
		return false;
	})
});
<?php echo '</script'; ?>
>

<center>
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categories']->value, 'category');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
?>
<div class="category">
	<form name="category_form<?php echo $_smarty_tpl->tpl_vars['category']->value['cat_id'];?>
" method="post" >
	<input type="hidden" name="action" value="start" />
	<input type="hidden" name="cat_id" value="<?php echo $_smarty_tpl->tpl_vars['category']->value['cat_id'];?>
" />
	<a href="javascript:;" rel="<?php echo $_smarty_tpl->tpl_vars['category']->value['cat_id'];?>
">
	<img align="left" src="<?php echo $_smarty_tpl->tpl_vars['category_dir']->value;
if ($_smarty_tpl->tpl_vars['category']->value['cat_thumbnail']) {
echo $_smarty_tpl->tpl_vars['category']->value['cat_thumbnail'];
} else { ?>default.jpg<?php }?>" width="100" height="100" /> <?php echo $_smarty_tpl->tpl_vars['category']->value['cat_name'];?>
 (<?php if ($_smarty_tpl->tpl_vars['category']->value['level_count']) {
echo $_smarty_tpl->tpl_vars['category']->value['level_count'];
} else { ?>0<?php }?>) </a><br>
	<?php echo $_smarty_tpl->tpl_vars['category']->value['cat_description'];?>

	</form>
</div>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
}
}
