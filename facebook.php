<?php
require_once('globals.php');
//$_SESSION['user_logged']=false;
require_once('includes/facebook.php');
$facebook = new Facebook(array(
  'appId'  => 'fb2093970f2f8355f1eb11bf781a8e45',
  'secret' => 'aff94b972704ee8220e5933d251733b0',
  'cookie' => true,
));

// session back in this case) or if the user logged out of Facebook.
$session = $facebook->getSession();

$me = null;
// Session based API call.
if ($session) {
  try {
    $uid = $facebook->getUser();
    $me = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
  }
}

// login or logout url will be needed depending on current user state.
if ($me) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl();
}

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
	  img{
		border:0;
	  }
    </style>
  </head>
  <body>
    <div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId   : '<?php echo $facebook->getAppId(); ?>',
          session : <?php echo json_encode($session); ?>, // don't refetch the session when PHP already has it
          status  : true, // check login status
          cookie  : true, // enable cookies to allow the server to access the session
          xfbml   : true // parse XFBML
        });

        // whenever the user logs in, we refresh the page
        FB.Event.subscribe('auth.login', function() {
          window.location.reload();
        });
      };

      (function() {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
      }());
    </script>


    <?php if ($me):
			if($_GET['view']=='play'){
				$facebook_id=$me['id'];
				$query=$db->query("select usr_id from user where facebook_id='$facebook_id' && usr_type='facebook'");
					if(!$query['rows'][0]['usr_id']){
					$facebook_link=$me['link'];
					$name=$me['name'];
					$db->query("insert into user (usr_type,facebook_id,facebook_link,usr_name) value('facebook','$facebook_id','$facebook_link','$name')",false);
					$usr_id=mysqli_insert_id($db->dbLink);
					$db->query("insert into user_score (usr_id,total_score) values('$usr_id',0)",false);
				}else{
					$usr_id=$query['rows'][0]['usr_id'];
				}
				$_SESSION['user_logged']=true; 
				$_SESSION['user_id']=$usr_id;
				include('index.php');
			}else{
	?>
    <a href="<?php echo $logoutUrl; ?>">
      <img src="http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif">
    </a>
	<center><a href="facebook.php?view=play"><img src="<?=config::$template_dir?>/images/play.png" width="128" height="128" /></center>
    <?php }
	else: ?>
    <div>
   <fb:login-button></fb:login-button>
    </div>
    <?php endif ?>
	
  
  </body>
</html>
