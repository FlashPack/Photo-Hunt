<?php
class bgmusic{
	function __construct(){} 
	public function dispatch(){
		if(is_callable(array($this,$_GET['action']))){
			$this->$_GET['action']();
		}elseif(is_callable(array($this,$_POST['action']))){
			$this->$_POST['action']();
		}else{
			$this->Main();
		}
	}
	public function Main(){
		global $db,$smarty;
		$bgmusics=$db->query("select * from bgmusic order by bgmusic_id desc ",true,true,15);
		$smarty->assign('bgmusics',$bgmusics['rows']);
		$smarty->assign('pages',$bgmusics['nav']['string']);
		$smarty->display('bgmusic/bgmusic.html');
	}
	public function delete(){
		global $db;
		$bgmusic_id=input::post('bgmusic_id');
		$bgmusic_file=$db->query("select bgmusic_file from bgmusic where bgmusic_id='$bgmusic_id'");
		@unlink(config::$upload_dir['audio'].$bgmusic_file['rows'][0]['bgmusic_file']);
		$db->query("delete from bgmusic where bgmusic_id='$bgmusic_id'",false);
	}
	public function delete_selected(){
		global $db;
		$bgmusic_ids=$_POST['bgmusic_ids'];
		foreach($bgmusic_ids as $bgmusic_id){
			$bgmusic_file=$db->query("select bgmusic_file from bgmusic where bgmusic_id='$bgmusic_id'");
			@unlink(config::$upload_dir['audio'].$bgmusic_file['rows'][0]['bgmusic_file']);
			$db->query("delete from bgmusic where bgmusic_id='$bgmusic_id'",false);
		}
		$this->Main();
	}
	public function new_file(){
		global $db,$smarty; 
		if($_POST['_submit1']){
			$types=array('audio/mpeg');
			$fileinfo=pathinfo($_FILES['file']['name']);
			$name=$_POST['bgmusic_name']?input::post('bgmusic_name'):$_FILES['file']['name'];
			$tmp_name=$_FILES['file']['tmp_name'];
			$new_name=rand_(10).'.'.$fileinfo['extension'];		
			if (!(in_array($_FILES['file']['type'],$types))){
				$alert= 'Only Mp3 file are allowed ';
				$error=true;
			}
			if(!$error && move_uploaded_file($tmp_name,config::$upload_dir['audio'].$new_name)){
				$db->query("insert into bgmusic (bgmusic_name,bgmusic_file) values('$name','$new_name')",false);
			}
			$smarty->assign('alerts',$alert);
		}
		$smarty->display('bgmusic/new_file.html');
	}
}
?>