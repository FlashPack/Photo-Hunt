<?php
class AutoLoader{
	public static $places=array('core/','includes/','modules/');
	public static $dir=NULL;
	public function __construct(){} 
	public static function autoload($file){
		if(self::$dir){
			$filepath=PATH.self::$dir.$file.'.class.php';
			if(is_file($filepath)){
				require_once($filepath);
			}else{
				self::recursiveAutoLoad($file,self::$dir);
			}
			self::$dir=NULL;
		}else{
			foreach(self::$places as $place){
				$filepath=PATH.$place.$file.'.class.php';
				if(is_file($filepath)){
					require_once($filepath) ; 
				}else{
					self::recursiveAutoLoad($file,$place); 
				}
			}
		}
	}
	public static function recursiveAutoLoad($file,$place){
		if(false !== ($handle=opendir($place))){
			while(false !==($entry=readdir($handle))){
				if(!in_array($entry,array('.','..'))){
					$filepath=$place.$entry.'/'.$file.'.class.php';
					if(is_file(PATH.$filepath)){
						require_once(PATH.$filepath); 
					}elseif(is_dir(PATH.$filepath)){
						self::recursiveAutoLoad($file,$place.$entry);
					}
				}
			}
		}
	}
}
?>