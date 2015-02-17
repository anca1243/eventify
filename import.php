<?php
//define('FACEBOOK_SDK_V4_SRC_DIR', '/facebook/src/Facebook/');
define('FACEBOOK_SDK_V4_SRC_DIR', '/facebook/src/Facebook/');
require_once __DIR__ .  '/facebook/autoload.php';
require_once( 'facebook/src/Facebook/HttpClients/FacebookHttpable.php' );
require_once( 'facebook/src/Facebook/HttpClients/FacebookCurl.php' );
require_once( 'facebook/src/Facebook/HttpClients/FacebookCurlHttpClient.php' );
require_once( 'facebook/src/Facebook/Entities/AccessToken.php' );
require_once( 'facebook/src/Facebook/Entities/SignedRequest.php' );
require_once( 'facebook/src/Facebook/FacebookSession.php' );
require_once( 'facebook/src/Facebook/FacebookRedirectLoginHelper.php' );
require_once( 'facebook/src/Facebook/FacebookRequest.php' );
require_once( 'facebook/src/Facebook/FacebookResponse.php' );
require_once( 'facebook/src/Facebook/FacebookSDKException.php' );
require_once( 'facebook/src/Facebook/FacebookRequestException.php' );
require_once( 'facebook/src/Facebook/FacebookOtherException.php' );
require_once( 'facebook/src/Facebook/FacebookAuthorizationException.php' );
require_once( 'facebook/src/Facebook/GraphObject.php' );
require_once( 'facebook/src/Facebook/GraphSessionInfo.php' );
require_once( 'facebook/src/Facebook/HttpClients/FacebookStreamHttpClient.php' );
require_once( 'facebook/src/Facebook/HttpClients/FacebookStream.php' );
?>
