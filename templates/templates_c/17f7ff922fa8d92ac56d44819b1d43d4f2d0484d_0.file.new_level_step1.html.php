<?php
/* Smarty version 3.1.30, created on 2017-11-07 22:47:04
  from "C:\xampp\htdocs\photo_hunt\templates\admin\levels\new_level_step1.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a0229d81819e5_47659625',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '17f7ff922fa8d92ac56d44819b1d43d4f2d0484d' => 
    array (
      0 => 'C:\\xampp\\htdocs\\photo_hunt\\templates\\admin\\levels\\new_level_step1.html',
      1 => 1280514462,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a0229d81819e5_47659625 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_block_alerts')) require_once 'C:\\xampp\\htdocs\\photo_hunt\\includes\\smarty_plugins\\block.alerts.php';
?>

<?php echo '<script'; ?>
 type="text/javascript">
$(function(){
	$('input[name="step1_submit"]').click(function(){
		if($('select[name="cat_id"]').val()==0){
			$('#alert1').html('Category is missing');
		}else if($('input[name="img1"]').val()==0){
			$('#alert1').html('Image 1 is missing');
		}else if($('input[name="img2"]').val()==0){
			$('#alert1').html('Image 2 is missing');
		}else{
			$('form[name="step1_form"]').submit();
		}
	});
});
<?php echo '</script'; ?>
>

<center>
<div class="breadcrumbs"><a href="admin.php">Control Panel</a> >> <a href="admin.php?view=levels">levels</a> >> New Level</div>
<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('alerts', array('id'=>"alert1"));
$_block_repeat1=true;
echo smarty_block_alerts(array('id'=>"alert1"), null, $_smarty_tpl, $_block_repeat1);
while ($_block_repeat1) {
ob_start();
$_block_repeat1=false;
echo smarty_block_alerts(array('id'=>"alert1"), ob_get_clean(), $_smarty_tpl, $_block_repeat1);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>

<form method="post" enctype="multipart/form-data" action="admin.php?view=levels&action=new_level" name="step1_form">
<table border="1" width="500">
<tr>
	<th>Level Name</th>
	<td><input type="text" name="lv_name" value="<?php echo $_smarty_tpl->tpl_vars['_POST']->value['cat_name'];?>
"></td>
</tr>
<tr>
	<th>Category*</th>
	<td><select name="cat_id">
	<option value="0"></option>
	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categories']->value, 'category');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
?>
	<option value="<?php echo $_smarty_tpl->tpl_vars['category']->value['cat_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['category']->value['cat_id'] == $_smarty_tpl->tpl_vars['level']->value['cat_id']) {?> }selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['category']->value['cat_name'];?>
</option>
	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
</select></td>
</tr>
<tr>
	<th>Image 1*</th>
	<td><input type="file" name="img1"></td>
</tr>
<tr>
	<th>Image 2*</th>
	<td><input type="file" name="img2"></td>
</tr>
<tr>
	<th>Active</th>
	<td><input type="checkbox" name="lv_status" <?php if ($_smarty_tpl->tpl_vars['_POST']->value['lv_status'] || !isset($_smarty_tpl->tpl_vars['_POST']->value['lv_status'])) {?> checked="checked"<?php }?>>Yes</td>
</tr>
<tr><input type="hidden" name="_submit1" value="true" >
	<input type="hidden" name="step" value="1" >
	<td colspan="2"><input type="button" name="step1_submit" value="continue" > </td>
</tr>

</table>
</form>
</center><?php }
}
