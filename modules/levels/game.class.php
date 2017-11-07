<?php
class game{
	function __construct(){} 
	public function start(){
		if(is_callable(array($this,$_GET['do']))){
			$do = $_GET['do'];
			$this->$do();
		}elseif(is_callable(array($this,$_POST['do']))){
			$do = $_POST['do'];
			$this->$do();
		}else{
			$this->game();
		}
	}
	public function game(){
		global $db,$smarty;
		$cat_id=input::get('cat_id');
		$smarty->assign('cat_id',$cat_id);
		$level=input::post('level');
		AutoLoader::$dir='modules/settings/';
		$settings=settings::get_settings();
		if($settings['levels']['bgmusic']){
			$file=$db->query("select bgmusic_file from bgmusic order by rand() limit 1");
			if($file['rows'][0]['bgmusic_file']){
				$smarty->assign('sound_file',config::$siteURL.config::$upload_dir['audio'].$file['rows'][0]['bgmusic_file']);
			}else{
				$settings['levels']['bgmusic']=0;
			}
		}
		$smarty->assign('settings',$settings);
		$category_levels=$db->query("select count(*) from level left join level_category on level.lv_id=level_category.lv_id where level_category.cat_id='$cat_id' && lv_status=1 ");
		$smarty->assign('category_levels_count',$category_levels['rows'][0]['count(*)']);
		$total_levels=$db->query("select count(*) from level where lv_status=1");
		$smarty->assign('total_levels',$total_levels['rows'][0]['count(*)']);
		$smarty->assign('level_dir',config::$upload_dir['levels']);
		$total_score=$db->query("select total_score from user_score where usr_id='".$_SESSION['user_id']."'");
		$smarty->assign('total_score',$total_score['rows'][0]['total_score']);
		$smarty->display('game/game.html');
		$_SESSION['played_levels']='';
	}
	public function get_level_data(){
		global $db; 
		$cat_id=input::post('cat_id');
		function remove_empty($input){
			if($input!=' '){
				return $input;
			}
		}
		if(is_array($_SESSION['played_levels'])){
			$played_levels="&& level_category.lv_id not in (".implode(',',$_SESSION['played_levels']).")";
		}
		$levelQuery=$db->query("select * from level left join level_category on level.lv_id=level_category.lv_id where level_category.cat_id='$cat_id' && level.lv_status=1  $played_levels  order by rand() limit 1");
		$lv_id=$levelQuery['rows'][0]['lv_id'];
		
		$images=$db->query("select * from image where lv_id='$lv_id' order by img_id asc");
		foreach($images['rows'] as $key=>$image){
			$xml.='<image id="img'.($key+1).'" src="'.$image['img_file'].'"></image>';
		}
		$images_spots=$db->query("select * from image_spot left join image on image.img_id=image_spot.img_id where image.lv_id='$lv_id'",true,true);
		if($images_spots['count']){
			foreach($images_spots['rows'] as $spot){
				$xml.='<spot x="'.$spot['spot_x'].'" y="'.$spot['spot_y'].'" width="'.$spot['spot_width'].'" height="'.$spot['spot_height'].'"></spot>';
			}
		}
		$xml.='<level_dir>'.config::$upload_dir['levels'].'</level_dir>';
		$_SESSION['played_levels'][]=$lv_id;
		
		header('Content-type: text/xml'); 
		echo '<level>'.$xml.'</level>';
	}
	function update_score(){
		global $db; 
		$total_score=input::post('total_score');
		$level=input::post('level');
		$db->query("update user_score set total_score='$total_score',played_levels=played_levels+$level where usr_id='".$_SESSION['user_id']."'",false); 
	}
}
?>