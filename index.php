<html>
 <head>
  <title>Eventify!</title>
  <?php require("style/linkcss.php"); ?>
 </head>
 <boy id=\"myPhoto\" src=\"http://www.ultralightinghire.co.uk/media/IMG_3397.jpg\" alt=\"party newparty\">
  <!-- Easy import of header -->
  <?php require("style/header.php");
        require("database.php");
	//User can change postcode, gets redirected here with a POST value
        if (isset($_POST['postcode']))
          $_SESSION['postcode'] = $_POST['postcode'];

	//Check if user is logged in, if not, display "welcome" page
        if (!isset($_SESSION["session"])) {
          echo "
           <h1 class=\"welcome\">Welcome to eventify</h1>
           <div class=\"row\" id=\"splash\">
            <div class=\"col s4\">
             <i id=\"icon\" class=\"mdi-action-event\"></i>
             <h3>TAGLINE</h3>
             <p>Something something find events. 
                Something something cure boredom</p>
           </div>
           <div class=\"col s4\">
            <i id=\"icon\" class=\"mdi-action-account-child\"></i>
            <h3>TAGLINE</h3>
            <p>Something something user interaction. 
               Something something fun with friends</p>
           </div>
           <div class=\"col s4\">
            <i id=\"icon\" class=\"mdi-action-done-all\"></i>
            <h3>TAGLINE</h3>
            <p>Something something yes indeed. 
               Something something else</p>
          </div>
      </div>
 // <img id=\"myPhoto\" src=\"http://www.ultralightinghire.co.uk/media/IMG_3397.jpg\" alt=\"party newparty\"/>
<script src=\"slideshow.js\"></script>
 <div id=\"container\">
 <div id=\"content\"></div>
</div>
<div id=\"footer\"> © 2014 Copyright X2</div>
</div>";

  } else {
    //If they are logged in, show the user events happening today
    require("geoIP.php");
    $user = fbRequest("/me");
    echo "<h3>Welcome back, ".$user['first_name']."</h3>\n";
    $location = getLocation();
    echo "<h4>Your location: ".$location['zipCode']."</h4>\n";
    echo "<h4>Events happening today, ". date('d M y') ."</h4>"; 
    $results = search_events("", "", date('d M y'), "", "","","");
    displayResults($results);
  }
 ?>
 <?php require("style/footer.php"); ?>
 </body>
</html>
