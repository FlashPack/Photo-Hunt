<?php
/* Smarty version 3.1.30, created on 2017-11-07 22:47:12
  from "C:\xampp\htdocs\photo_hunt\templates\admin\categories\categories.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a0229e0636999_80771904',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '689f720c2886e74522e99c06670fb4a92699bf0c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\photo_hunt\\templates\\admin\\categories\\categories.html',
      1 => 1280528058,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a0229e0636999_80771904 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_block_alerts')) require_once 'C:\\xampp\\htdocs\\photo_hunt\\includes\\smarty_plugins\\block.alerts.php';
?>

<?php echo '<script'; ?>
 type="text/javascript">
$(function(){
	$('.cat_active').click(function(){
		_activate(this,'admin.php?view=categories&action=activate&ajax=true','cat_id');
	});
	$('.delete_btn').click(function(){
		_delete(this,'admin.php?view=categories&action=delete&ajax=true','cat_id','#alert1');
	});
	$('td').click(function(){
		if($(this).find('.text').html()!=null){
			$(this).find('.edit').show();
			$(this).find('.text').hide();
		}
	});
	$('input[name="save"]').click(function(){
		selector=$(this).parent().children();
		selector.each(function(){
			if($(this).attr('type')!='button' && $(this)[0].nodeName!='BR'){
				parent=$($(this).parent()).parent();
				tds=$(parent).parent().children();
				cat_id=$(tds[0]).find('input').val();
				field=$(this).attr('name');
				value=$(this).val();
				$.ajax({
					type:'post',
					url:'admin.php?view=categories&action=update&ajax=true',
					data:'cat_id='+cat_id+'&'+field+'='+value,
					beforeSend:function(){
						$('#alert1').html('<img src="templates/images/loading.gif" />');
					},
					success:function(response){
						$('#alert1').html('<br>');
						parent.find('.edit').hide();
						parent.find('.text').html(value).show();
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
				$('#alert1').html('Please Select at least one category');
			}
		}else{
			$('#alert1').html('');
		}
	});
	$('#new_cat_btn,.thumbnail_change').click(function(){
		if($('#container').html()=='') get_page($(this).attr('href'),'#container');
		return false;
	});
	
	<?php if ($_smarty_tpl->tpl_vars['alerts']->value) {?>
		get_page($('#new_cat_btn').attr('href'),'#container');
	<?php }?>
	
});
<?php echo '</script'; ?>
>

<center>
<div class="breadcrumbs"><a href="admin.php">Control Panel</a> >> Categories</div>
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
<a href="admin.php?view=categories&action=new_category&ajax=true" id="new_cat_btn">New Categoey</a>
<form method="post" name="form1" action="admin.php?view=categories">
<table border="1" width="75%">
<thead>
<tr>
	<th width="20">
	<input type="checkbox" name="checkAll" value="checkbox" />
	</th>
	<th width="20%">
	Category Name  
	</th>
	<th width="50%">
	Description  
	</th>
	<th>
	Thumbnail  
	</th>
	<th>
	Levels  
	</th>
	<th  width="50">
	Active 
	</th>
	</th>
	<th  width="50">
	Delete 
	</th>
</tr>
</thead>
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categories']->value, 'category');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
?>
<tr>
	<td>
	<input type="checkbox" class="checkbox" name="cat_ids[]" value="<?php echo $_smarty_tpl->tpl_vars['category']->value['cat_id'];?>
"  />
	</td>
	<td>
	<a href="javascript:;" class="text"><?php echo $_smarty_tpl->tpl_vars['category']->value['cat_name'];?>
</a>
	<div class="edit"><input type="text" name="cat_name" value="<?php echo $_smarty_tpl->tpl_vars['category']->value['cat_name'];?>
" size="15" /> <br><input type="button" name="save" value="Save"></div>
	</td>
	<td>
	<div class="text">
	<?php echo $_smarty_tpl->tpl_vars['category']->value['cat_description'];?>

	</div>
	<div class="edit"><textarea name="cat_description" ><?php echo $_smarty_tpl->tpl_vars['category']->value['cat_description'];?>
</textarea><br> <input type="button" name="save" value="Save"></div>
	&nbsp;
	
	</td>
	<td>
	<a href="admin.php?view=categories&action=thumbnail_form&ajax=true&cat_id=<?php echo $_smarty_tpl->tpl_vars['category']->value['cat_id'];?>
" class="thumbnail_change" title="click to change"><img src="<?php echo $_smarty_tpl->tpl_vars['category_dir']->value;
if ($_smarty_tpl->tpl_vars['category']->value['cat_thumbnail']) {
echo $_smarty_tpl->tpl_vars['category']->value['cat_thumbnail'];
} else { ?>default.jpg<?php }?>" width="100" height="100" /></a> &nbsp;
	</td>
	<td>
	<?php if ($_smarty_tpl->tpl_vars['category']->value['levels']) {
echo $_smarty_tpl->tpl_vars['category']->value['levels'];
} else { ?>0<?php }?> &nbsp;
	</td>
	<td>
	<input type="checkbox"  class="cat_active" rel="<?php echo $_smarty_tpl->tpl_vars['category']->value['cat_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['category']->value['cat_status']) {?> checked="checked" <?php }?>  />
	</td>
	<td>
	<a href="javascript:;" class="delete_btn" rel="<?php echo $_smarty_tpl->tpl_vars['category']->value['cat_id'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
images/delete.png" /></a></td>
</tr>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

</table>
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
