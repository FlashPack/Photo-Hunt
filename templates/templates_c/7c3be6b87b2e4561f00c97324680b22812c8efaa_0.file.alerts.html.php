<?php
/* Smarty version 3.1.30, created on 2017-11-07 22:44:07
  from "C:\xampp\htdocs\photo_hunt\templates\alerts.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a0229276a59d7_86553225',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7c3be6b87b2e4561f00c97324680b22812c8efaa' => 
    array (
      0 => 'C:\\xampp\\htdocs\\photo_hunt\\templates\\alerts.html',
      1 => 1279967990,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a0229276a59d7_86553225 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="<?php if ($_smarty_tpl->tpl_vars['params']->value['border']) {?>alert_border<?php }?> alert" id="<?php echo $_smarty_tpl->tpl_vars['params']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['alerts']->value) {?>style="display:block"<?php }?>>
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['alerts']->value, 'alert');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['alert']->value) {
echo $_smarty_tpl->tpl_vars['alert']->value;?>
<br />
<?php
}
} else {
?>

<?php echo $_smarty_tpl->tpl_vars['alert']->value;?>

<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

</div><?php }
}
