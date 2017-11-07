<?php
/* Smarty version 3.1.30, created on 2017-11-07 22:46:14
  from "C:\xampp\htdocs\photo_hunt\templates\admin\bgmusic\bgmusic.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a0229a6b32c62_76789578',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'deed36e349de0aadfcda9d3e0cb3db428241f4f2' => 
    array (
      0 => 'C:\\xampp\\htdocs\\photo_hunt\\templates\\admin\\bgmusic\\bgmusic.html',
      1 => 1280460386,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a0229a6b32c62_76789578 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_block_alerts')) require_once 'C:\\xampp\\htdocs\\photo_hunt\\includes\\smarty_plugins\\block.alerts.php';
?>

<?php echo '<script'; ?>
 type="text/javascript">
$(function(){
	$('.delete_btn').click(function(){
		_delete(this,'admin.php?view=bgmusic&action=delete&ajax=true','bgmusic_id','#alert1');
	});
	$('select[name="action"]').change(function(){
		if($(this).val()!='0'){
			if($('.checkbox:checked').length>=1){
				if($(this).val()=='delete_selected'){
					if(confirm('Are you sure ? ')){
						$('form[name="form1"]').submit();
						$('#alert1').html('<br>');
					}
				}else{
					$('form[name="form1"]').submit();
					$('#alert1').html('<br>');
				}
			}else{
				$('#alert1').html('Please Select at least one audio file');
			}
		}else{
			$('#alert1').html('');
		}
	});
});
<?php echo '</script'; ?>
>

<center>
<div class="breadcrumbs"><a href="admin.php">Control Panel</a> >> BgMusic</div>
<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('alerts', array('id'=>"alert1"));
$_block_repeat1=true;
echo smarty_block_alerts(array('id'=>"alert1"), null, $_smarty_tpl, $_block_repeat1);
while ($_block_repeat1) {
ob_start();
$_block_repeat1=false;
echo smarty_block_alerts(array('id'=>"alert1"), ob_get_clean(), $_smarty_tpl, $_block_repeat1);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>

<div id="container"></div>
<a href="admin.php?view=bgmusic&action=new_file" id="new_lv_btn">New File</a>
<form method="post" name="form1">
<table border="1" width="75%">
<thead>
<tr>
	<th width="20">
	<input type="checkbox" name="checkAll" value="checkbox" />
	</th>
	<th>
	Name  
	</th>
	<th  width="50">
	Delete 
	</th>
	
</tr>
</thead>
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['bgmusics']->value, 'bgmusic');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['bgmusic']->value) {
?>
<tr>
	<td>
	<input type="checkbox" class="checkbox" name="bgmusic_ids[]" value="<?php echo $_smarty_tpl->tpl_vars['bgmusic']->value['bgmusic_id'];?>
"  />
	</td>
	<td>
	<?php echo $_smarty_tpl->tpl_vars['bgmusic']->value['bgmusic_name'];?>

	</div>
	</td>
		<td>
	<a href="javascript:;" class="delete_btn" rel="<?php echo $_smarty_tpl->tpl_vars['bgmusic']->value['bgmusic_id'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
images/delete.png" /></a></td>
</tr>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

</table>
<div><?php echo $_smarty_tpl->tpl_vars['pages']->value;?>
</div>
<br>
On Selected 
<select name="action">
	<option value="0"></option>
	<option value="delete_selected">Delete</option>
</select>
</form>
</center><?php }
}
