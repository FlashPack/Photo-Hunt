<?php
class categories{
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
		if($_POST['_submit']){
			$error=false;
			$cat_name=input::post('cat_name');
			$cat_description=input::post('cat_description');
			$cat_status=input::post('cat_status')=='on'?1:0;
			$image=new image;
			if($_FILES['cat_thumbnail']['error']!=4){
				if(!$image->upload(config::$upload_dir['categories'],$_FILES['cat_thumbnail'],array(config::$upload_dir['categories']=>array(100,100)))){
					$alerts[]=$image->error;
					$smarty->assign('_POST',$_POST);
					$error=true;
				}else{
					$cat_thumbnail=$image->new_name;
				}
			}
			if(!$error){
				$db->query("insert into category (cat_name,cat_description,cat_thumbnail,cat_status) values ('$cat_name','$cat_description','$cat_thumbnail','$cat_status')",false);
				$alerts[] = 'Category was added';
			}
			$smarty->assign('alerts',$alerts);
		}elseif($_GET['action']=='thumbnail_change'){
			if($_POST['_submit_thumbnail']){
				$cat_id=input::get('cat_id');
				$img=$db->query("select cat_thumbnail from category where cat_id='$cat_id'");
				$error=false;
				$image=new image;
				if($_FILES['cat_thumbnail']['error']!=4){
					if(!$image->upload(config::$upload_dir['categories'],$_FILES['cat_thumbnail'],array(config::$upload_dir['categories']=>array(100,100)))){
						$alerts[]=$image->error;
						$smarty->assign('_POST',$_POST);
						$error=true;
					}else{
						$cat_thumbnail=$image->new_name;
						$db->query("update category set cat_thumbnail='$cat_thumbnail' where cat_id='$cat_id'",false);
						if($img['rows'][0]['cat_thumbnail']){
							@unlink(config::$upload_dir['categories'].$img['rows'][0]['cat_thumbnail']);
						}
					}
				}
			}
		}
		$catQuery=$db->query("select *,(select count(*) from level_category where level_category.cat_id=category.cat_id) as levels from category order by cat_id asc");
		$smarty->assign('categories',$catQuery['rows']);
		$smarty->assign('category_dir',config::$upload_dir['categories']);
		$smarty->display('categories/categories.html');
	}
	public function thumbnail_form(){
		global $smarty ; 
		$smarty->assign('cat_id',$_GET['cat_id']);
		$smarty->display('categories/c_thumbnail_form.html');
	}
	public function activate(){
		global $db;
		$cat_id=input::post('cat_id');
		if(input::post('status')=='false'){
			$db->query("update category set cat_status=0 where cat_id='$cat_id'",false);
		}else{
			$db->query("update category set cat_status=1 where cat_id='$cat_id'",false);
		}
	}
	public function delete(){
		global $db;
		$cat_id=input::post('cat_id');
		$cat=$db->query("select cat_thumbnail from category where cat_id='$cat_id'");
		if($cat['rows'][0]['cat_thumbnail']){
			@unlink(config::$upload_dir['categories'].$cat['rows'][0]['cat_thumbnail']);
		}
		$db->query("delete from category where cat_id='$cat_id'",false);
	}
	public function delete_selected(){
		global $db;
		$cat_ids=$_POST['cat_ids'];
		foreach($cat_ids as $cat_id){
			$cat=$db->query("select cat_thumbnail from category where cat_id='$cat_id'");
			if($cat['rows'][0]['cat_thumbnail']){
				unlink(config::$upload_dir['categories'].$cat['rows'][0]['cat_thumbnail']);
			}
			$db->query("delete from category where cat_id='$cat_id'",false);
		}
		$this->Main();
	}
	public function activate_selected(){
		global $db;
		$cat_ids=$_POST['cat_ids'];
		foreach($cat_ids as $cat_id){
			$db->query("update  category set cat_status=1 where cat_id='$cat_id'",false);
		}
		$this->Main();
	}
	public function deactivate_selected(){
		global $db;
		$cat_ids=$_POST['cat_ids'];
		foreach($cat_ids as $cat_id){
			$db->query("update  category set cat_status=0 where cat_id='$cat_id'",false);
		}
		$this->Main();
	}
	public function update(){
		global $db ;
		$cat_id=$_POST['cat_id'];
		array_shift($_POST);
		foreach($_POST as $key=>$value){
			$name=$key; 
			$value=$value;
		}
		$db->query("update category set $name='$value' where cat_id='$cat_id'",false);
	}
	
	public function new_category(){
		global $smarty,$db ;
		$categories=$db->query("select cat_id,cat_name from category order by cat_id asc ");
		$smarty->assign('categories',$categories['rows']);
		$smarty->display('categories/new_category.html');
	}
	

}
?>