<?php
// Awesome FB APP 
//
// Name: MyAPP 
//
require_once 'facebook.php';// this line calls our facebook.php file that is the core of PHP facebook API

// Create our Application instance.
$facebook = new Facebook(array(
  'appId' => '215681628615224',
  'secret' => '944b46222759f0516bfb697762fe4041',
  'cookie' => true,
)); // all we are doing is creating an array for facebook to use with our app id and app secret in and setting the cookie to true
try {
  $me = $facebook->api('/me');
} catch (FacebookApiException $e) {
  error_log($e);
} // this code is saying if the session to the app is created use the $me as a selector for the information or die
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Facebook APP</title>
</head>

<body>
<? if ($facebook->getSession()) { ?>
<form action="signup.php" method="post">
<fieldset class="field_name">
<label>First Name</label>
<input class="name" name="first_name" type="text" value="<? if ($facebook->getSession()) {echo $me['first_name'];}else{echo'First Name';} ?>" />
</fieldset>
<fieldset class="field_name">
<label>Last Name</label>
<input class="name" name="last_name" type="text" value="<? if ($facebook->getSession()) {echo $me['last_name'];}else{echo'Last Name';} ?>" />
</fieldset>
<fieldset>
<label>Email Address</label>
<input name="email" type="text" value="<? if ($facebook->getSession()) {echo $me['email'];}else{echo'email address';} ?>" />
</fieldset>
<fieldset>
<input name="submit" type="submit" value="submit" />
</fieldset>
</form>
<? } else {
  ?>
<p>Sign up with Facebook <fb:login-button perms="email,user_checkins,user_location,publish_stream,user_birthday,offline_access"> Connect</fb:login-button> It only takes a few seconds</p>
<div id="fb-root"></div>
      <script src="http://connect.facebook.net/en_US/all.js"></script>
      <script>
         FB.init({ 
            appId:'215681628615224', cookie:true, 
            status:true, xfbml:true 
         });
		 FB.Event.subscribe('auth.login', function(response) {
        window.location.reload(); //will reload your page you are on
      });
      </script> 
 <? }
?> 
</body>
</html>