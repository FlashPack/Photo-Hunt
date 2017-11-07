<?php
/* Smarty version 3.1.30, created on 2017-11-07 22:50:23
  from "C:\xampp\htdocs\photo_hunt\templates\admin\levels\new_level_step2.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a022a9f947812_79268650',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7e96b36e06a6fda58b0fced1100ca3acb097aec3' => 
    array (
      0 => 'C:\\xampp\\htdocs\\photo_hunt\\templates\\admin\\levels\\new_level_step2.html',
      1 => 1280510036,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a022a9f947812_79268650 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_block_alerts')) require_once 'C:\\xampp\\htdocs\\photo_hunt\\includes\\smarty_plugins\\block.alerts.php';
echo '<script'; ?>
 type="text/javascript" src="js/admin/image_spots.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 type="text/javascript">
$(function(){
	
});
<?php echo '</script'; ?>
>

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

<br>
<form method="post" enctype="multipart/form-data" action="admin.php?view=levels&action=new_level" name="step3_form">
<div class="image_box" >
<div  class="spacer" id="spacer1" style="width:<?php echo $_smarty_tpl->tpl_vars['settings']->value['levels']['image_width'];?>
px;height:<?php echo $_smarty_tpl->tpl_vars['settings']->value['levels']['image_height'];?>
px;" ></div>
<img src="<?php echo $_smarty_tpl->tpl_vars['img1']->value;?>
" width="<?php echo $_smarty_tpl->tpl_vars['settings']->value['levels']['image_width'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['settings']->value['levels']['image_width'];?>
" class="image" id="<?php echo $_smarty_tpl->tpl_vars['img1_id']->value;?>
" />
</div>
<div class="image_box">
<div  id="spacer2" style="position:absolute;width:<?php echo $_smarty_tpl->tpl_vars['settings']->value['levels']['image_width'];?>
px;height:<?php echo $_smarty_tpl->tpl_vars['settings']->value['levels']['image_height'];?>
px;" ></div>
<img src="<?php echo $_smarty_tpl->tpl_vars['img2']->value;?>
" width="<?php echo $_smarty_tpl->tpl_vars['settings']->value['levels']['image_width'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['settings']->value['levels']['image_width'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['img2_id']->value;?>
" />
</div>
<div class="track_box">
	<div class="new_spots">
	</div>
	<div class="total">Total Spots : <span></span></div>
	<br>
	<div class="mouse_x">Mouse X:<span></span></div>
	<div class="mouse_y">Mouse Y:<span></span></div>
</div>
<input type="hidden" name="lv_status" value="<?php echo $_smarty_tpl->tpl_vars['lv_status']->value;?>
" >
<input type="hidden" name="lv_id" value="<?php echo $_smarty_tpl->tpl_vars['lv_id']->value;?>
" >
<input type="hidden" name="_submit3" value="true" >
<br clear="all" />
<center>
<input type="submit" name="step3_submit" value="Finish" >
</center><?php }
}
