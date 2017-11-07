<?php
class Levels{
	function __construct(){} 
	public function dispatch(){
		if(is_callable(array($this,$_GET['action']))){
			$func = $_GET['action'];
			$this->$func();
		}elseif(is_callable(array($this,$_POST['action']))){
			$func = $_POST['action'];
			$this->$func();
		}else{
			$this->Main();
		}
	}
	public function Main(){
		global $db,$smarty;
		$levels=$db->query("select level.lv_id,level_category.cat_id,(select cat_name from category where category.cat_id=level_category.cat_id limit 1) as cat_name,level.lv_name,level.lv_thumbnail,level.lv_status from level left join level_category on level.lv_id=level_category.lv_id order by lv_id asc ",true,true,15);
		$categories=$db->query("select cat_id,cat_name from category order by cat_id asc ");
		$smarty->assign('categories',$categories['rows']);
		$smarty->assign('levels',$levels['rows']);
		$smarty->assign('pages',$levels['nav']['string']);
		$smarty->assign('level_dir',config::$upload_dir['levels_thumbnails']);
		$smarty->display('levels/levels.html');
	}
	public function activate(){
		global $db;
		$lv_id=input::post('lv_id');
		if(input::post('status')=='false'){
			$db->query("update level set lv_status=0 where lv_id='$lv_id'",false);
		}else{
			$db->query("update level set lv_status=1 where lv_id='$lv_id'",false);
		}
	}
	public function delete(){
		global $db;
		$lv_id=input::post('lv_id');
		$lv_thumbnail=$db->query("select lv_thumbnail from level where lv_id='$lv_id'");
		$imgs=$db->query("select img_id,img_file from image where lv_id='$lv_id'");
		if($lv_thumbnail['rows'][0]['lv_thumbnail']){
			@unlink(config::$upload_dir['levels_thumbnails'].$lv_thumbnail['rows'][0]['lv_thumbnail']);
		}
		foreach($imgs['rows'] as $img){
			@unlink(config::$upload_dir['levels'].$img['img_file']);
			$db->query("delete from image_spot where img_id='".$img['img_id']."'",false);
		}
		$db->query("delete from image where lv_id='$lv_id'",false);
		$db->query("delete from level where lv_id='$lv_id'",false);
		$db->query("delete from level_category where lv_id='$lv_id'",false);
	}
	public function delete_selected(){
		global $db;
		$lv_ids=$_POST['lv_ids'];
		foreach($lv_ids as $lv_id){
			$lv_thumbnail=$db->query("select lv_thumbnail from level where lv_id='$lv_id'");
			$imgs=$db->query("select img_id,img_file from image where lv_id='$lv_id'");
			if($lv_thumbnail['rows'][0]['lv_thumbnail']){
				@unlink(config::$upload_dir['levels_thumbnails'].$lv_thumbnail['rows'][0]['lv_thumbnail']);
			}
			if($imgs['rows']){
				foreach($imgs['rows'] as $img){
					@unlink(config::$upload_dir['levels'].$img['img_file']);
					$db->query("delete from image_spot where img_id='".$img['img_id']."'",false);
				}
			}
			$db->query("delete from image where lv_id='$lv_id'",false);
			$db->query("delete from level where lv_id='$lv_id'",false);
			$db->query("delete from level_category where lv_id='$lv_id'",false);
		}
		$this->Main();
	}
	public function activate_selected(){
		global $db;
		$lv_ids=$_POST['lv_ids'];
		foreach($lv_ids as $lv_id){
			$db->query("update  level set lv_status=1 where lv_id='$lv_id'",false);
		}
		$this->Main();
	}
	public function deactivate_selected(){
		global $db;
		$lv_ids=$_POST['lv_ids'];
		foreach($lv_ids as $lv_id){
			$db->query("update  level set lv_status=0 where lv_id='$lv_id'",false);
		}
		$this->Main();
	}
	public function update_category(){
		global $db ;
		$lv_id=$_POST['lv_id'];
		$cat_id=$_POST['cat_id'];
		$db->query("update level_category set cat_id='$cat_id' where lv_id='$lv_id'",false);
	}
	public function new_level(){
		global $db,$smarty; 
		
		$smarty->assign('step',$step=$_POST['step']?$_POST['step']:0);
		if($step==0){
			$categories=$db->query("select cat_id,cat_name from category order by cat_id asc ");
			$smarty->assign('categories',$categories['rows']);
			$smarty->display('levels/new_level_step1.html');
		}elseif($step==1){
			if($_POST['_submit1']){
				$lv_name=input::post('lv_name'); 
				$cat_id=input::post('cat_id');
				$lv_status=input::post('lv_status')=='on'?1:0;
				$image=new image;
				AutoLoader::$dir='modules/settings/';
				$settings=settings::get_settings('levels');
				$smarty->assign('settings',$settings);
				if($_FILES['img1']['error']!=4){
					if(!$image->upload(config::$upload_dir['levels'],$_FILES['img1'],array(config::$upload_dir['levels']=>array($settings['levels']['image_width'],$settings['levels']['image_height']),config::$upload_dir['levels_thumbnails']=>array(120,120)))){
						$alerts[]=$image->error;
						$error=true;
					}else{
						$img1=$image->new_name;
						list($img1_width,$img1_height)=getimagesize(config::$upload_dir['levels'].$img1);
					}
				}
				if($_FILES['img2']['error']!=4){
					if(!$image->upload(config::$upload_dir['levels'],$_FILES['img2'],array(config::$upload_dir['levels']=>array($settings['levels']['image_width'],$settings['levels']['image_height'])))){
						$alerts[]=$image->error;
						$error=true;
					}else{
						$img2=$image->new_name;
						list($img2_width,$img2_height)=getimagesize(config::$upload_dir['levels'].$img2);
					}
				}
				if(!$error){
					$db->query("insert into level (lv_name,lv_thumbnail,lv_date,lv_status) values ('$lv_name','$img1',unix_timestamp(),0)",false);
					$lv_id=mysqli_insert_id($db->dbLink);
					$db->query("insert into level_category (lv_id,cat_id) values ('$lv_id','$cat_id')",false);
					$db->query("insert into image (lv_id,img_file,img_width,img_height) values ('$lv_id','$img1','$img1_width','$img1_height')",false);
					$img1_id=mysqli_insert_id($db->dbLink);
					$db->query("insert into image (lv_id,img_file,img_width,img_height) values ('$lv_id','$img2','$img2_width','$img2_height')",false);
					$img2_id=mysqli_insert_id($db->dbLink);
					$step=2;
				}else{
					$categories=$db->query("select cat_id,cat_name from category order by cat_id asc ");
					$smarty->assign('categories',$categories['rows']);
					$smarty->assign('alerts',$alerts);
					$smarty->display('levels/new_level_step1.html');
				}
			}
		}
		if($step==2){
			$smarty->assign('img1',config::$upload_dir['levels'].$img1);
			$smarty->assign('img1_id',$img1_id);
			$smarty->assign('img2',config::$upload_dir['levels'].$img2);
			$smarty->assign('img2_id',$img2_id);
			$smarty->assign('lv_id',$lv_id);
			$smarty->assign('lv_status',$lv_status);
			$smarty->display('levels/new_level_step2.html');
		}
		if($_POST['_submit3']){
			if($_POST['lv_status']=='1'){
				$lv_id=$_POST['lv_id'];
				$db->query("update level set lv_status=1 where lv_id='$lv_id'",false);
			}
			echo '<script>location.replace("admin.php?view=levels")</script>';
		}		
	}
	public function insert_spot(){
		global $db;
		extract($_POST); 
		$img_id=str_replace('spot','',$img_id);
		$db->query("insert into image_spot (img_id,spot_x,spot_y,spot_width,spot_height) values('$img_id','$x','$y','$width','$height')",false);
		echo mysqli_insert_id($db->dbLink);
	}
	public function remove_spot(){
		global $db;
		extract($_POST); 
		$db->query("delete from image_spot where spot_id='$spot_id'",false);
	}
	function edit(){
		global $db,$smarty;
		$lv_id=input::get('lv_id');
		AutoLoader::$dir='modules/settings/';
		$settings=settings::get_settings('levels');
		$smarty->assign('settings',$settings);
		$images=$db->query("select img_id,img_file from image where lv_id='$lv_id' order by image.img_id asc");
		$images_spots=$db->query("select * from image_spot left join image on image.img_id=image_spot.img_id where image.lv_id='$lv_id'");
		$smarty->assign('img1',config::$upload_dir['levels'].$images['rows'][0]['img_file']);
		$smarty->assign('img1_id',$images['rows'][0]['img_id']);
		$smarty->assign('img2',config::$upload_dir['levels'].$images['rows'][1]['img_file']);
		$smarty->assign('img2_id',$images['rows'][1]['img_id']);
		$smarty->assign('lv_id',$lv_id);
		$smarty->assign('lv_status',$lv_status);
		$smarty->display('levels/edit.html');
	}
	function get_data(){
		global $db ;
		$lv_id=input::post('lv_id');
		$images_spots=$db->query("select * from image_spot left join image on image.img_id=image_spot.img_id where image.lv_id='$lv_id' order by spot_id asc");
		foreach($images_spots['rows'] as $spot){
			$xml.='<spot spot_id="'.$spot['spot_id'].'" x="'.$spot['spot_x'].'" y="'.$spot['spot_y'].'" width="'.$spot['spot_width'].'" height="'.$spot['spot_height'].'"></spot>';
		}
		header('Content-type: text/xml'); 
		echo '<level>'.$xml.'</level>';
	}
}
?>