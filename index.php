<html>
 <head>
  <title>Eventify!</title>
  <?php require("style/linkcss.php"); ?>
 </head>
  
  <!-- Easy import of header -->
  <?php require("style/header.php");
        require("database.php");
	//User can change postcode, gets redirected here with a POST value
        if (isset($_POST['postcode']))
          $_SESSION['postcode'] = $_POST['postcode'];

	//Check if user is logged in, if not, display "welcome" page
        if (!isset($_SESSION["session"])) {
          echo "
          <header>
           <h1 class=\"welcome\">Welcome to Eventify</h1>
          </header>
            <div class=\"row\" id=\"splash\">
            <div class=\"col s4\">
             <i id=\"icon\" class=\"mdi-action-event\"></i>
             <h3><b>Find Events...</p>
            </div>
           <div class=\"col s4\">
            <i id=\"icon\" class=\"mdi-social-location-city\"></i>
            <h3><b>In your city...</b></h3>
           </div>
           <div class=\"col s4\">
            <i id=\"icon\" class=\"mdi-social-mood\"></i>
            <h3>Cure your boredom!</b></h3>
          </div>
      </div><br><br>
      <h2>Start by logging in, the button is over there!<br>
      <i class='mdi-hardware-keyboard-return'></i></h2>";

  } else {
    //If they are logged in, show the user events happening today
    require("geoIP.php");
    $user = fbRequest("/me");
    echo "<h2>Welcome back, ".$user['first_name']."</h2>\n";
    $location = getLocation();
    echo "<h4>Your location: ".$location['zipCode']."</h4>\n";
    echo "<h4>What's been happening recently</h4>";
    echo "---Filler, Here will be a feed of all users activity that I follow---";
  }
 ?>

 <?php require("style/footer.php"); ?>
</html>
