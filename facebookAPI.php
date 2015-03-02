<html>
<!--
##############################################################################
#                                                                            #
#                                                                            #
#             	          YOUR ATTENTION PLEASE                              #
#                                                                            #
#                     HERE BE DRAGONS. MAGIC. WITCHES.                       #
#                                                                            #
#                         WARNED, YOU HAVE BEEN                              #
#                                                                            #
#                                                                            #
##############################################################################
-->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
</script>
<div id="fb-root"></div>

<?php
  // Skip these two lines if you're using Composer
  require("import.php");
  
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
  //require("config.php");
  FacebookSession::setDefaultApplication($facebook_appID, $facebook_appSec);
  $helper = new FacebookRedirectLoginHelper($url."login.php");
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
    //Add id to array for later use
    $_SESSION['id'] = $userData["id"];
    echo '<a href="logout.php"><i class="mdi-navigation-close"></i>';
    echo 'Logout</a></li>';
    echo '<li><div id="fbpicture"><a href="user.php?id=\''.$userData['id'].'\'">';
    echo '<img src=\'//graph.facebook.com/'.$userData["id"].'/picture\'>';
    echo $userData['first_name'].'&nbsp';
    echo $userData['last_name'].'&nbsp&nbsp</a></div></li>';
  } else {
    // show login url
    echo '<a href="' . $helper->getLoginUrl() . '"><i class="mdi-social-person"></i>Login</a>';
  } 

function fbRequest($req) {
  if (!isset($_SESSION['session'])) {
      echo "<p>You must be logged in to do that.\n <a href='index.html'>Go back to homepage</a></p>";
      die;
  } else {
      $session = $_SESSION['session'];
      $request = new FacebookRequest($session, "GET", "/".$req);
      $response = $request->execute();
      $response =  $response->getGraphObject()->asArray();
      return $response;
    }
}

?>
</html>
