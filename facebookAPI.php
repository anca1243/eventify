<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
</script>
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
    try {
      FB.login(function (response) {
        if (response.authResponse) {
          console.log(response.authResponse.accessToken);
          //transfer token to server with ajax
        }
      }, {scope: 'email'});
    } catch (e) {};

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
  // Skip these two lines if you're using Composer
  define('FACEBOOK_SDK_V4_SRC_DIR', '/facebook/src/Facebook/');
  require __DIR__ . '/facebook/autoload.php';
  require( 'facebook/src/Facebook/HttpClients/FacebookHttpable.php' );
  require( 'facebook/src/Facebook/HttpClients/FacebookCurl.php' );
  require( 'facebook/src/Facebook/HttpClients/FacebookCurlHttpClient.php' );
  require( 'facebook/src/Facebook/Entities/AccessToken.php' );
  require( 'facebook/src/Facebook/Entities/SignedRequest.php' );
  require( 'facebook/src/Facebook/FacebookSession.php' );
  require( 'facebook/src/Facebook/FacebookRedirectLoginHelper.php' );
  require( 'facebook/src/Facebook/FacebookRequest.php' );
  require( 'facebook/src/Facebook/FacebookResponse.php' );
  require( 'facebook/src/Facebook/FacebookSDKException.php' );
  require( 'facebook/src/Facebook/FacebookRequestException.php' );
  require( 'facebook/src/Facebook/FacebookOtherException.php' );
  require( 'facebook/src/Facebook/FacebookAuthorizationException.php' );
  require( 'facebook/src/Facebook/GraphObject.php' );
  require( 'facebook/src/Facebook/GraphSessionInfo.php' );
  require( 'facebook/src/Facebook/HttpClients/FacebookStreamHttpClient.php' );
  require( 'facebook/src/Facebook/HttpClients/FacebookStream.php' );
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
  use Facebook\HttpClients\FacebookStreamHttpClient;
  use Facebook\HttpClients\FacebookStream;
  session_start();
  FacebookSession::setDefaultApplication('837275619665461','6aafcab796d6f35bd3eeca0b2ea31586');
  $helper = new FacebookRedirectLoginHelper('http://192.168.0.103/index.php' );
  if (isset($_SESSION["session"]))
    $session = $_SESSION["session"]; 
  if (!isset($session)) {
  try {
    $session = $helper->getSessionFromRedirect();
  } catch( FacebookRequestException $ex ) {
    echo $ex;
    // When Facebook returns an error
  } catch( Exception $ex ) {
    echo $ex;
    // When validation fails or other local issues
  }
  }
  // see if we have a session
  if ( isset( $session ) ) {
    // graph api request for user data
    $request = new FacebookRequest( $session, 'GET', '/me' );
    $response = $request->execute();
    // get response
    $graphObject = $response->getGraphObject();
    $_SESSION["session"] = $session;
    // print data
    $userData = $graphObject->asArray();
    echo '<a href="logout.php"><i class="mdi-navigation-close">';
    echo '</i>Logout</a><div id="fbPicture">'.$userData['first_name'].' '.$userData['last_name'].'&nbsp&nbsp';
    echo '<img src="//graph.facebook.com/'.$userData["id"].'/picture"></div>';
  } else {
    // show login url
    echo '<a href="' . $helper->getLoginUrl() . '"><i class="mdi-social-person"></i>Login</a>';
  } 

?>
