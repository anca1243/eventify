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
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '837275619665461',
      xfbml      : true,
      version    : 'v2.2'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

</script>
<meta property="fb:app_id" content="837275619665461" />
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
    if ($kiosk) {
      // If you're making app-level requests:
      $session = FacebookSession::newAppSession();

      // To validate the session:
      try {
        $session->validate();
      } catch (FacebookRequestException $ex) {
        // Session not valid, Graph API returned an exception with the reason.
        echo $ex->getMessage();
      } catch (\Exception $ex) {
        // Graph API returned info, but it may mismatch the current app or have expired.
        echo $ex->getMessage();
      }
  } else 
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
    if ($kiosk)
    $request = new FacebookRequest( $session, 'GET', '/210675532436098' );
    else 
    $request = new FacebookRequest( $session, 'GET', '/me' );
    $response = $request->execute();
    // get response
    $graphObject = $response->getGraphObject();
    $_SESSION["session"] = $session;
    // print data
    $userData = $graphObject->asArray();
    //Add id to array for later use
    if ($kiosk) {
      $_SESSION['id'] = "210675532436098";
    } else
      $_SESSION['id'] = $userData["id"];
    echo '<li>
    <a href="search.php?evtitle=&evdate=&evpostcode=&evdesc=&maxdist=&city="><i class="mdi-action-search" style="vertical-align:middle;"></i><p>Search</p></a>
   </li>';
    echo '<li><a href="logout.php"><i class="mdi-navigation-close" style="vertical-align:middle;"></i>';
    echo '<p>Logout</p></a></li>';
    echo '<li><div id="fbpicture"><a href="user.php?id=\''.$userData['id'].'\'"><i class="mdi-action-verified-user"></i>';
    echo '<p>'.$userData['name'].'</p>';
    echo '</a></div></li>';
  } else {
    // show login url
    echo '<a href="guestlogin.php?url=' . $helper->getLoginUrl() . '"><i class="mdi-social-person" style="vertical-align:middle;"></i><p>Login</p></a>';
  } 
 function fbRequest($req) {
  if (!isset($_SESSION['session'])) {
      echo "<<p>You must be logged in to do that.<br><br> <a href='index.php'>Go back to homepage</a></p>";
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
