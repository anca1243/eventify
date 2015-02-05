<div id="fb-root"></div>
  <script>     

  window.fbAsyncInit = function() {
    FB.init({
      appId: '837275619665461', 
      status: true,
         cookie: true,
         xfbml: true,
       channelUrl:'/channel.html',
      frictionlessRequests: true,
      useCachedDialogs: true,
      oauth: true
    });
    FB.Event.subscribe('auth.login', function(response) {
      window.location.reload();
    });
    FB.Event.subscribe('auth.logout', function(response) {
      window.location.reload();
    });
  };
(function(d){
   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
      js.src = "//connect.facebook.net/en_US/all.js";
    ref.parentNode.insertBefore(js, ref);
     }(document));
      </script>

<?php
  header('P3P: CP="CAO PSA OUR"');
  session_start();
  // Skip these two lines if you're using Composer
  define('FACEBOOK_SDK_V4_SRC_DIR', '/facebook/src/Facebook/');
  require __DIR__ . '/facebook/autoload.php';
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
  use Facebook\HttpClients\FacebookHttpable;
  use Facebook\HttpClients\FacebookCurl;
  use Facebook\HttpClients\FacebookCurlHttpClient;
  use Facebook\Entities\AccessToken;
  use Facebook\Entities\SignedRequest;
  use Facebook\FacebookSession;
  use Facebook\FacebookRedirectLoginHelper;
  use Facebook\FacebookRequest;
  use Facebook\FacebookResponse;
  use Facebook\FacebookSDKException;
  use Facebook\FacebookRequestException;
  use Facebook\FacebookOtherException;
  use Facebook\FacebookAuthorizationException;
  use Facebook\GraphObject;
  use Facebook\GraphSessionInfo;
  FacebookSession::setDefaultApplication('837275619665461','6aafcab796d6f35bd3eeca0b2ea31586');
  // start session
  echo $_SESSION;
  // login helper with redirect_uri
  $helper = new FacebookRedirectLoginHelper( 'http://192.168.0.103/' );
  // see if a existing session exists
  if ( isset( $_SESSION ) && isset( $_SESSION['fb_token'] ) ) {
   // create new session from saved access_token
   $session = new FacebookSession( $_SESSION['fb_token'] );
   // validate the access_token to make sure it's still valid
   try {
    if ( !$session->validate() ) {
    $session = null;
   }
  } catch ( Exception $e ) {
  // catch any exceptions
    $session = null;
  }
  }
  if ( !isset( $session ) || $session === null ) {
  // no session exists
  try {
   $session = $helper->getSessionFromRedirect();
  } catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
  // handle this better in production code
  print_r( $ex );
  } catch( Exception $ex ) {
   // When validation fails or other local issues
   // handle this better in production code
   print_r( $ex );
  }
}
// see if we have a session
  if ( isset( $session ) ) {
  // save the session
  $_SESSION['fb_token'] = $session->getToken();
  // create a session using saved token or the new one we generated at login
  $session = new FacebookSession( $session->getToken() );
  // graph api request for user data
  $request = new FacebookRequest( $session, 'GET', '/me' );
  $response = $request->execute();
  // get response
  $graphObject = $response->getGraphObject()->asArray();
  // print profile data
  //echo '<pre>' . print_r( $graphObject, 1 ) . '</pre>';
  // print logout url using session and redirect_uri (logout.php page should destroy the session)
  //echo '<img src="//graph.facebook.com/'.$graphObject['id'].'/picture">';
  echo '<a href="' . $helper->getLogoutUrl( $session, 'http://192.168.0.103/' ) . '"><i class="mdi-content-undo"></i>Logout</a>';
  } else {
  // show login url
  echo '<a href="' . $helper->getLoginUrl( array( 'email', 'user_friends' ) ) . '"><i class="mdi-image-timer-auto"></i>Login</a>';
  } 
?>
