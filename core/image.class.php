<?php
class image{
	public $new_name ; 
	public $error = '';
	function upload($dir,$file_data,$thumbnail=NULL)
	{
		$image_types=array('image/jpg','image/jpeg','image/pjpeg','image/png','image/x-png','image/gif','image/bmp','image/tif');
		$imageinfo=pathinfo($file_data['name']);
		$tmp_name=$file_data['tmp_name'];
		$new_name=rand_(10).'.'.$imageinfo['extension'];		
		if (!(in_array($file_data['type'],$image_types))){
			$this->error = 'Extension is not allowed ';
			return false ; 
		}
		if(move_uploaded_file($tmp_name,$dir.$new_name)){
			if ($thumbnail){
				  $this->resize($dir.$new_name,$new_name,$thumbnail,$imageinfo['extension']);
				  $this->new_name=$new_name;
				  return true ; 
			}else{
				$this->new_name=$new_name;
				return true ; 
			}
		}else{
			$this->error='Error Uploading the image';
			return false ; 
		}
	}
	function resize($source_name,$new_name,$resize_data,$extension=NULL){
		$extension=$extension==NULL?substr($new_name,-4,3):$extension;
		switch(strtolower($extension)){
			case 'jpg':
			case 'jpeg':
				$source_img=imagecreatefromjpeg($source_name);
			break;
			case 'gif':
			$source_img=imagecreatefromgif($source_name);
			break;
			case 'png':
				$source_img=imagecreatefrompng($source_name);
			break;
			default:
				return true;
			}
			foreach($resize_data as $dir=>$new_size){
				unset($thumbnail,$width,$height,$new_width,$new_height,$new_percentage);
				list($width,$height)=getimagesize($source_name);
				list($new_width,$new_height)=$new_size;
				if($new_width=='x'){
					$new_percentage=$new_height/$height*100;
					$new_width=$width<=$new_width?$width:$new_percentage*$width/100;
				}
				if($new_height=='x'){
					$new_percentage=$new_width/$width*100;
					//do not resize if the new height is less than the original height
					$new_height=$height<=$new_height?$height:$new_percentage*$height/100;
				}
				if($width>=$new_width){
					$thumbnail=imagecreatetruecolor($new_width,$new_height);
					imagecopyresampled($thumbnail,$source_img,0,0,0,0,$new_width,$new_height,$width,$height);
					imagejpeg($thumbnail,$dir.$new_name);
				}
			}
			
	}
}


?>