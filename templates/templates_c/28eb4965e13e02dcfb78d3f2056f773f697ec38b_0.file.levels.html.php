<?php
/* Smarty version 3.1.30, created on 2017-11-07 22:46:18
  from "C:\xampp\htdocs\photo_hunt\templates\admin\levels\levels.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a0229aac12569_21248145',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '28eb4965e13e02dcfb78d3f2056f773f697ec38b' => 
    array (
      0 => 'C:\\xampp\\htdocs\\photo_hunt\\templates\\admin\\levels\\levels.html',
      1 => 1280509426,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a0229aac12569_21248145 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_block_alerts')) require_once 'C:\\xampp\\htdocs\\photo_hunt\\includes\\smarty_plugins\\block.alerts.php';
?>

<?php echo '<script'; ?>
 type="text/javascript">
$(function(){
	$('.cat_active').click(function(){
		_activate(this,'admin.php?view=levels&action=activate&ajax=true','lv_id');
	});
	$('.delete_btn').click(function(){
		_delete(this,'admin.php?view=levels&action=delete&ajax=true','lv_id','#alert1');
	});
	$('input[name="save"]').click(function(){
		selector=$(this).parent().children();
		selector.each(function(){
			if($(this).attr('type')!='button' && $(this)[0].nodeName!='BR'){
				parent=$($(this).parent()).parent();
				tds=$(parent).parent().children();
				lv_id=$(tds[0]).find('input').val();
				value=$(this).val();
				text=$(this).find(':selected').text();
				$.ajax({
					type:'post',
					url:'admin.php?view=levels&action=update_category&ajax=true',
					data:'lv_id='+lv_id+'&cat_id='+value,
					beforeSend:function(){
						$('#alert1').html('<img src="templates/images/loading.gif" />');
					},
					success:function(response){
						$('#alert1').html('<br>');
						parent.find('.edit').hide();
						parent.find('.text').html(value!='0'?text:'Uncategorized').show();
					}
				})
			}
		});
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
				$('#alert1').html('Please Select at least one Level');
			}
		}else{
			$('#alert1').html('');
		}
	});
});
<?php echo '</script'; ?>
>

<center>
<div class="breadcrumbs"><a href="admin.php">Control Panel</a> >> levels</div>
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
<a href="admin.php?view=levels&action=new_level" id="new_lv_btn">New Level</a>
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
	<th>
	Thumbnail  
	</th>
	<th>
	Category  
	</th>
	<th  width="50">
	Active 
	</th>
	</th>
	<th  width="50">
	Edit
	</th>
	<th  width="50">
	Delete 
	</th>
	
</tr>
</thead>
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['levels']->value, 'level');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['level']->value) {
?>
<tr>
	<td>
	<input type="checkbox" class="checkbox" name="lv_ids[]" value="<?php echo $_smarty_tpl->tpl_vars['level']->value['lv_id'];?>
"  />
	</td>
	<td>
	<!--<a href="javascript:;" class="text"><?php echo $_smarty_tpl->tpl_vars['level']->value['lv_name'];?>
</a>--><?php echo $_smarty_tpl->tpl_vars['level']->value['lv_name'];?>

	<div class="edit"><input type="text" name="lv_name" value="<?php echo $_smarty_tpl->tpl_vars['level']->value['lv_name'];?>
" size="15" /> <br><input type="button" name="save" value="Save"></div>
	</td>
	<td>
	<img src="<?php echo $_smarty_tpl->tpl_vars['level_dir']->value;
if ($_smarty_tpl->tpl_vars['level']->value['lv_thumbnail']) {
echo $_smarty_tpl->tpl_vars['level']->value['lv_thumbnail'];
} else { ?>default.jpg<?php }?>" width="120" height="120" /> &nbsp;
	</td>
	<td>
	<a href="javascript:;" class="text"><?php if ($_smarty_tpl->tpl_vars['level']->value['cat_name']) {
echo $_smarty_tpl->tpl_vars['level']->value['cat_name'];
} else { ?>Uncategorized<?php }?></a>
	<div class="edit"><select name="lv_id"><option value="0"></option<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categories']->value, 'category');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
?><option value="<?php echo $_smarty_tpl->tpl_vars['category']->value['cat_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['category']->value['cat_id'] == $_smarty_tpl->tpl_vars['level']->value['cat_id']) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['category']->value['cat_name'];?>
</option><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
</select><input type="button" name="save" value="Save"></div>
	</td>
	<td>
	<input type="checkbox"  class="cat_active" rel="<?php echo $_smarty_tpl->tpl_vars['level']->value['lv_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['level']->value['lv_status']) {?> checked="checked" <?php }?>  />
	</td>
	<td>
	<a href="admin.php?view=levels&action=edit&lv_id=<?php echo $_smarty_tpl->tpl_vars['level']->value['lv_id'];?>
" class="edit_btn" ><img src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
images/tool.png" /></a></td>
	<td>
	<a href="javascript:;" class="delete_btn" rel="<?php echo $_smarty_tpl->tpl_vars['level']->value['lv_id'];?>
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
	<option value="activate_selected">Activate</option>
	<option value="deactivate_selected">Deactivate</option>
</select>
</form>
</center><?php }
}
