<?php
class config{
	public static $dbServer= 'localhost';

	public static $dbUser  = 'root';
	
	public static $dbPass  = '';
	
	public static $dbName  = 'photohunt';
	
	public static $siteURL ='http://localhost/photo_hunt/';
	
	public static $nonReplyEmail='non-reply@site.com';
	
	public static $debug = true;
	
	public static $smarty_plugins_dir='includes/smarty_plugins/';
	
	public static $template_dir='templates/';
	
	public static $template_cache='templates/templates_c/';

	public static $frontend_whitelist= array('home','categories','play','frontend','register','login');
	
	public static $backend_whitelist= array('levels','categories','settings','bgmusic','users','statistics');
	
	public static $upload_dir  = array(
									   'dir'=>'uploads/',
									   'categories'=>'uploads/categories/',
									   'levels'=>'uploads/levels/',
									   'levels_thumbnails'=>'uploads/levels/thumbnails/',
									   'audio'=>'uploads/audio/'
									  );
}

ini_set('register_globals', false);
?>