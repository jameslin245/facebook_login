<?php
  // Remember to copy files from the SDK's src/ directory to a
  // directory in your application on the server, such as php-sdk/
	require '../src/facebook.php';

	$facebook = new Facebook(array(
	'appId'  => 'your_appId',
	'secret' => 'your_secret',
	));
	if($_GET['urls'] == 'logout' && $_GET['code'] == ''){
		unset($user);
	}else{
		$user = $facebook->getUser();
	}
    if ($user) {
		try {
			// Proceed knowing you have a logged in user who's authenticated.
			$user_profile = $facebook->api('/me');
		} catch (FacebookApiException $e) {
			error_log($e);
			$user = null;
		}
	}

	if ($user) {
	  $logoutUrl = 'example.php?urls=logout';
	} else {
	  $loginUrl = $facebook->getLoginUrl();
	}  

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>php-login</title>
  </head>
  <body>
	<h1>php-login</h1>
  <?php

	//print_r($user_profile);
	if ($user) {
		echo '<a href="'.$logoutUrl.'">Logout</a>';
	}else{
		echo '<a href="'.$loginUrl.'">Login with Facebook</a>';
	}
	//print_r($user_profile);
	if($user){
		echo '<br><br><img src="https://graph.facebook.com/'.$user.'/picture">';
		echo '<br>ID:'.$user_profile['id'];
		echo '<br>生日:'.$user_profile['birthday'];
		echo '<br>姓名:'.$user_profile['name'];
		echo '<br>Email:'.$user_profile['email'];
	}
  ?>

  </body>
</html>