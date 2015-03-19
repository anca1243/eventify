
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
  if (isset($_SESSION["kiosk"])) {
    $kiosk = $_SESSION["kiosk"];
  } else {
    $_SESSION["kiosk"] = false;
    $kiosk = false;
  } 
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
  if ( isset( $session) ) {
    // graph api request for user data
    if ($kiosk == true)
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
    if ($kiosk == true) {
      $_SESSION['id'] = "210675532436098";
    } else
      $_SESSION['id'] = $userData["id"];
       
      $nav_buttons = '
      <li>
     <h4>
     <a href="search.php?evtitle=&evdate=&evpostcode=&evdesc=&maxdist=&city=">
     Find Events</h4></a>
   </li>
    <li>
     <h4><a href="logout.php">Logout</h4></a>
   </li>
    <li><h4><div id="fbpicture"><a href="user.php?id=\''.$userData['id'].'\'">
     '.$userData['name'].'\'s Profile
    </a></div></h4></li>';
      $mobile_nav_buttons = '
      <li class="no-padding">
          <ul class="collapsible collapsible-accordion">
            <li><a class="collapsible-header  
             waves-effect waves-teal">Find Events</a>
              <div class="collapsible-body">
                <ul>
                  <li><a href="search.php?evtitle=&evdate=&evpostcode=&evdesc=&maxdist=&city=">Search All</a></li>
                  <li><a href="search.php?evtitle=&evdate=&evpostcode=&evdesc=&maxdist=10&city=">Near Me</a></li>
                  
                </ul>
              </div>
            </li>
          </ul>
         </li>
         <li>
     <a href="logout.php">Logout</a>
   </li>
    <li><div id="fbpicture"><a href="user.php?id=\''.$userData['id'].'\'">
     '.$userData['name'].'\'s Profile
    </a></div></li>';
  } else {
    //show login url
    $desktop_nav_buttons = '<li>
           <a href="chooselogin.php">Login</a></li>';
    $mobile_nav_buttons = $desktop_nav_buttons;
  } 
 function fbRequest($req) {
  if (!isset($_SESSION['session'])) {
      echo "<p>You must be logged in to do that.<br><br> <a href='index.php'>Go back to homepage</a></p>";
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


