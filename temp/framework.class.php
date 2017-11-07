<?php
/**
* Framework Class is the main class that responsible for managing the whole classes and modules 
* Project : actcompany.com
* File : Electronics4world.class.php
* Link : http://www.electronics4world.com
* Author : AmmAr Abelhamied <ammar@ammardev.com>
**/

require_once('includes/config.php');
class framework{

	static $_instance;
	private $template;
	private $settings=array(); 	
	private $contentTemplate;
	public $smarty ;
	public $view ; 
	public $ajax ; 
	public $cache_file='cache/homepage.tmp';
	private function __construct(){
		//Imorting the database connection
		global $db ;
		//Compress the buffer using gzip
		$this->gzip_compress();

		$run=true;
		
		//Creating Database Object
		$db=new mysql;
		$db->connect(config::$dbServer,config::$dbUser, config::$dbPass);
		$db->select_db(config::$dbName);
				
	
		//Creating Session Object 
		$session=new session();
		 
		//Creating Smarty Template Object
		$this->smarty=new Smarty;
		$this->smarty->compile_check = true;
		$this->smarty->php_handling=SMARTY_PHP_ALLOW ;
		define('template','web2-mix');
		$this->smarty->plugins_dir[]='includes/smarty_plugins/';
		$this->smarty->template_dir='templates/'.template.'/';
		$this->smarty->compile_dir='templates/'.template.'/template_c/';
		$this->smarty->assign('thisPage',$thisPage=get_url());
		$this->view=guard($_GET['view']);
		
		// Assign Settings 
		$_GET['id']?$this->smarty->assign('id',$id=guard($_GET['id'])):NULL;
		$this->smarty->assign('template_dir',config::$siteURL.'/'.$this->smarty->template_dir);
		$this->smarty->assign('url',config::$siteURL);
		
		
		$this->ajax=$_GET['ajax']?$_GET['ajax']:$_POST['ajax']?$_POST['ajax']:NULL;
		$settings=$this->view?"('mini_title')":"('full_title','site_keywords','site_description','last_update')";
		//Get Settings
		$settingsQuery=$db->query("select name,value from settings where name in $settings");
		foreach($settingsQuery['rows'] as $key=>$value) $this->set_setting($value['name'],$value['value']);
		if(in_array($this->view,config::$view_whitelist)){
			$this->smarty->assign('view',$view=$_GET['view']);
			switch($view){
				case 'admin':
					if($session->check()){
						include('admin/admin.php');
					}else{
						$this->smarty->assign('alert',$session->alert);
						$this->set_template('admin/login.html');
					}
				break;
				case 'login':
					include('admin/login.php');
				break;
				case 'categories':
					include('controllers/categories.php');
					break;
				case 'article':
					include('controllers/article.php');
					break;
				case 'article_comments':
					include('controllers/article_comments.php');
					break;
				case 'login':
					include('controllers/login.php');
				break;
				case 'compress':
					if($_GET['type']=='css' || $_GET['type']=='javascript') $this->gzip_compress(true,$_GET['type']);
				break;
				case 'contact':
					include('controllers/contact.php');
				break;
				case 'electronic_dictionary':
					include('controllers/electronic_dictionary.php');
				break;
				case 'search':
					include('controllers/search.php');
				break;
				case 'sitemap':
					include('controllers/sitemap.php');
				break;
				case 'newsletter':
					include('controllers/newsletter.php');
				break;
				case 'circuits':
					//include('controllers/contact.php');
					$this->smarty->assign('circuits','hover');
				break;
				case 'del_cache':
					$db->query("update settings set value=unix_timestamp() where name='last_update'",false);
				default:
					//$use_cache=$this->get_setting('last_update')<=filemtime($this->cache_file);
					//if(!$use_cache) 
					include('controllers/home.php');
			}
			/*if(!$use_cache && !$view){
				$this->output();
				file_put_contents($this->cache_file,ob_get_contents());
				ob_end_flush();
			}elseif(!$view){
				echo file_get_contents($this->cache_file);	
			}else{*/
				$this->output();
			//}
		}
	}
	public function set_template($template,$string=false){
		$this->contentTemplate=$string?$template:$this->smarty->fetch($template);
	}
	public function gzip_compress($set_header=false,$type=NULL){
		if(strpos($_SERVER['HTTP_ACCEPT_ENCODING'],'gzip')!==false) ob_start('ob_gzhandler');
		if($set_header){
			$type?header('Content-type: text/'.$type.';charset: UTF-8'):NULL;
			header('Cache-Control: must-revalidate');
			$offset = 3600 * 24 ;
			$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s",time() + $offset) . " GMT";
			header($ExpStr);
		}
	}
	public function output(){
		global $db; 
		if(!$_GET['ajax']){
			//Navbar Menu Elements
			$menuQuery=$db->query("select cat_id,cat_name,cat_parent from categories where cat_parent in ( 1, 5 )",false);
			while(list($cat_id,$cat_name,$cat_parent)=mysqli_fetch_array($menuQuery)){
				$menus[$cat_parent][]=array('cat_id'=>$cat_id,'cat_name'=>$cat_name);
			}
			$this->smarty->assign('menus',$menus);
			//Components Widget
			$articlesQuery=$db->query("select art_id,art_title,art_thumbnail from articles where art_cat=6 && art_id!=20 order by rand() limit 3",true,true);
			for($i=0;$i<$articlesQuery['count'];$i++){
				$articlesQuery['rows'][$i][]=$result;
				if(is_file(config::$upload_dir['articles']['small'].$articlesQuery['rows'][$i]['art_thumbnail'])){
					$articlesQuery['rows'][$i]['art_thumbnail']=config::$upload_dir['articles']['small'].$articlesQuery['rows'][$i]['art_thumbnail'];
				}elseif(is_file(config::$upload_dir['original']['original'].$articlesQuery['rows'][$i]['art_thumbnail'])){
					$articlesQuery['rows'][$i]['original']=$articlesQuery['rows'][$i]['art_thumbnail']=config::$upload_dir['articles']['original'].$articlesQuery['rows'][$i]['art_thumbnail'];
				}else
					$articlesQuery['rows'][$i]['art_thumbnail']='';	
			}
			$this->smarty->assign('components',$articlesQuery['rows']);
			
			$this->smarty->assign('site_title',$this->get_setting('full_title')?$this->get_setting('full_title'):$this->get_setting('mini_title'));
			$this->smarty->assign('site_keywords',$this->get_setting('site_keywords'));
			$this->smarty->assign('site_description',strip_tags($this->get_setting('site_description')));
			$this->smarty->assign('contentTemplate',$this->contentTemplate);
			$this->smarty->assign('year',date('Y'));
			$this->smarty->display('index.html');
		}
	}
	public function set_setting($name,$value){
		if(!in_array($name,$this->settings)){
			$this->settings[$name]=$value;
		}
	}
	public function get_setting($name){
		return $this->settings[$name];
	}
	private function __clone(){
	}
	public static function inilaize(){
		if(!(self::$_instance instanceof self)){
			self::$_instance=new self();
		}
		return self::$_instance;
	}
	
	function __destruct(){
		//$this->db->close();
	}
}
?>