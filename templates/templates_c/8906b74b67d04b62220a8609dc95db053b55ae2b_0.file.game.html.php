<?php
/* Smarty version 3.1.30, created on 2017-11-07 22:57:34
  from "C:\xampp\htdocs\photo_hunt\templates\game\game.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a022c4e70fb41_43949799',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8906b74b67d04b62220a8609dc95db053b55ae2b' => 
    array (
      0 => 'C:\\xampp\\htdocs\\photo_hunt\\templates\\game\\game.html',
      1 => 1510091851,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a022c4e70fb41_43949799 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['category_levels_count']->value >= 1) {?>
<head>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
css/play.css" media="all" />
<link type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
ui-lightness/jquery-ui-1.8.2.custom.css" rel="stylesheet" />	
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
css/style.css" media="all" />
<?php echo '<script'; ?>
 type="text/javascript" src="js/jquery-1.4.2.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="js/jquery-ui-1.8.2.custom.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="js/game.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="js/jquery.timer.js"><?php echo '</script'; ?>
>
<?php if ($_smarty_tpl->tpl_vars['settings']->value['levels']['bgmusic']) {
echo '<script'; ?>
 language="JavaScript" src="js/audio-player.js"><?php echo '</script'; ?>
>
<?php }?>

<?php echo '<script'; ?>
 type="text/javascript">
//Disable Right Click 
function clickIE4(){
	if (event.button==2){
		return false;
	}
}
function clickNS4(e){
	if (document.layers||document.getElementById&&!document.all){
		if (e.which==2||e.which==3){
			return false;
		}
	}
}
if (document.layers){
	document.captureEvents(Event.MOUSEDOWN);
	document.onmousedown=clickNS4;
}else if (document.all&&!document.getElementById){
	document.onmousedown=clickIE4;
}
document.oncontextmenu=new Function("return false;");
//Game Intiltizing
$(function(){
	$('.game').game({
		image1_id:'#img1',
		image2_id:'#img2',
		current_level_id:'#current_level',
		total_levels_id:'#total_levels',
		level_score_id:'#level_score',
		game_score_id:'#game_score',
		total_score_id:'#total_score',
		spots_left_id:'#spots_left',
		wrong_clicks_id:'#wrong_clicks',
		spot_progress_id:'#spot_progress',
		pause_dialog:'#pause_dialog',
		level_report_dialog:'#level_report_dialog',
		game_report_dialog:'#game_report_dialog',
		loading_id:'#loading',
		cat_id:$('input[name="cat_id"]').val(),
		
		sound:<?php echo $_smarty_tpl->tpl_vars['settings']->value['levels']['bgmusic'];?>
,
		total_score:<?php echo $_smarty_tpl->tpl_vars['total_score']->value;?>
,
		allowed_hints:<?php echo $_smarty_tpl->tpl_vars['settings']->value['levels']['allowed_hints'];?>
,
		timer_duration:<?php echo $_smarty_tpl->tpl_vars['settings']->value['levels']['timer_duration'];?>
,
		allowed_pauses:<?php echo $_smarty_tpl->tpl_vars['settings']->value['levels']['allowed_pauses'];?>
,
		correct_click_score:<?php echo $_smarty_tpl->tpl_vars['settings']->value['score_calc']['correct_click'];?>
,
		unusedhints_score:<?php echo $_smarty_tpl->tpl_vars['settings']->value['score_calc']['unused_hints'];?>
,
		time_bonus_score:<?php echo $_smarty_tpl->tpl_vars['settings']->value['score_calc']['time_bonus'];?>
,
		wrong_click_p:<?php echo $_smarty_tpl->tpl_vars['settings']->value['score_calc']['wrong_click'];?>

		
	});
	$('#pause_dialog').dialog({
		autoOpen: false,
		width: 775,
		height:500
	});
	$('#level_report_dialog').dialog({
		autoOpen: false,
		width: 500,
		height:400
	});
	$('#game_report_dialog').dialog({
		autoOpen: false,
		width: 500,
		height:400
	});
	sound=true;
	$('#sound').click(function(){
		if(sound==true){
			sound=false;
			$('#audioplayer1').hide();
			$(this).html('Sound On');
		}else{
			sound=true;
			$('#audioplayer1').show();
			$(this).html('Sound Off');
		}
		return false;
	})
});
<?php echo '</script'; ?>
>
</head>

<div class="game">
<div class="loading" id="loading"></div>
<input type="hidden" name="cat_id" value="<?php echo $_smarty_tpl->tpl_vars['cat_id']->value;?>
" />
<div class="left">
<div class="box" id="current_level">Current Level :
	<br><span>1</span>
</div>
<div class="box" id="total_levels">Total Levels :
	<br><span><?php echo $_smarty_tpl->tpl_vars['total_levels']->value;?>
</span>
</div>
</div>
<div class="right">
<div class="box" id="level_score">Level Score :
	<br><span></span>
</div>
<div class="box" id="game_score">Game Score :
	<br><span></span>
</div>
 <div class="box" id="total_score">Total Score : 
	<br><span><?php echo $_smarty_tpl->tpl_vars['total_score']->value;?>
</span>
</div>
</div>
<center>
<div class="buttons">
	<a href="javascript:;" rel="pause">Pause Game</a> ||
	<?php if ($_smarty_tpl->tpl_vars['settings']->value['levels']['bgmusic']) {?>
	<a href="javascript:;" id="sound">Sound Off</a> ||
	<?php }?>
	<a href="javascript:;" rel="new">New Game</a>
</div>
<div class="hints">
	<?php
$__section_hint_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_hint']) ? $_smarty_tpl->tpl_vars['__smarty_section_hint'] : false;
$__section_hint_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['settings']->value['levels']['allowed_hints']) ? count($_loop) : max(0, (int) $_loop));
$__section_hint_0_total = $__section_hint_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_hint'] = new Smarty_Variable(array());
if ($__section_hint_0_total != 0) {
for ($__section_hint_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_hint']->value['index'] = 0; $__section_hint_0_iteration <= $__section_hint_0_total; $__section_hint_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_hint']->value['index']++){
?>
	<a href="javascript:;" rel="unused"><img src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
images/help-icon.jpg" width="100" /></a>
	<?php
}
}
if ($__section_hint_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_hint'] = $__section_hint_0_saved;
}
?>
</div>
<div class="timer">Time left  : <span><?php echo $_smarty_tpl->tpl_vars['settings']->value['levels']['timer_duration'];?>
</span></div>
</center>
<br clear="all" />
<div class="spacer" id="spacer1" style="width:<?php echo $_smarty_tpl->tpl_vars['settings']->value['levels']['image_width'];?>
px;height:<?php echo $_smarty_tpl->tpl_vars['settings']->value['levels']['image_height'];?>
px;" ></div>
<div id="img1" class="photo" >
<img src="" width=<?php echo $_smarty_tpl->tpl_vars['settings']->value['levels']['image_width'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['settings']->value['levels']['image_height'];?>
" />
</div>
<div class="spacer" id="spacer2" style="width:<?php echo $_smarty_tpl->tpl_vars['settings']->value['levels']['image_width'];?>
px;height:<?php echo $_smarty_tpl->tpl_vars['settings']->value['levels']['image_height'];?>
px;" ></div>

<div id="img2" class="photo">
<img src="" width=<?php echo $_smarty_tpl->tpl_vars['settings']->value['levels']['image_width'];?>
" height="<?php echo $_smarty_tpl->tpl_vars['settings']->value['levels']['image_height'];?>
" />
</div>
<br clear="all" />
<div class="right" style="margin-top:20px;">
<div class="box" id="spots_left">Spots Left : 
	<br><span></span>
</div>
 <div class="box" id="wrong_clicks">Wrong Clicks
	<br><span></span>
</div>
</div>
<center>
<div class="spot_progress" id="spot_progress">
	<img src="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
images/correct-icon.jpg" width="34" height="34" />
</div>
</center>
<div id="pause_dialog" title="Game Pause">
	<div class="remained_pauses">Remained Pauses : <span></span></div> <br>
	<div class="allowed_pauses">Allowed Pauses : <span></span></div><br>
	<input type="button" class="game_contine" value="contine" />
</div>
<div id="level_report_dialog" title="Level Report">
	<div class="level_score">Level Score: <span></span></div> <br>
	<div class="time_bonus">Time Bonus Score : <span></span></div><br>
	<div class="unusedhints_bonus">Unused Hints Bonus : <span></span></div><br>
	<hr>
	<div class="level_total_score">Total Level Score : <span></span></div><br>
	<input type="button" class="next_level" value="contine" />
</div>
<div id="game_report_dialog" title="Game Report">
	<div class="game_score">Game Score: <span></span></div> <br>
	<div class="total_score">Total Score: <span></span></div> <br>
	<div class="played_levels">Played Levels : <span></span></div><br>
	<div class="wrong_clicks">Wrong Clicks : <span></span></div><br>
	<hr>
		<input type="button" class="finish" value="Finish" /> <input type="button" class="new_game" value="New Game" />
</div>
<?php if ($_smarty_tpl->tpl_vars['settings']->value['levels']['bgmusic']) {?>
<object type="application/x-shockwave-flash" data="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
player.swf" id="audioplayer1" height="1" width="1">
<param name="movie" value="<?php echo $_smarty_tpl->tpl_vars['template_dir']->value;?>
player.swf">
<param name="FlashVars" value="autostart=yes&playerID=audioplayer1&soundFile=<?php echo $_smarty_tpl->tpl_vars['sound_file']->value;?>
">
<param name="quality" value="high">
<param name="menu" value="false">
<param name="wmode" value="transparent">
</object> 
<?php }?>
</div>
<?php } else { ?>
There is no levels
<?php }
}
}
