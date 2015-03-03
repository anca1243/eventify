<html>
 <head>
  <title>Eventify!</title>
  <?php require("style/linkcss.php"); ?>
 </head>
 <body>
  
  <!-- Easy import of header -->
  <?php require("style/header.php");
        require("database.php");
	//User can change postcode, gets redirected here with a POST value
        if (isset($_POST['postcode']))
          $_SESSION['postcode'] = $_POST['postcode'];

	//Check if user is logged in, if not, display "welcome" page
        if (!isset($_SESSION["session"])) {
          echo "
           <h1 class=\"welcome\">Welcome to Eventify</h1>
           <div class=\"row\" id=\"splash\">
            <div class=\"col s4\">
             <i id=\"icon\" class=\"mdi-action-event\"></i>
             <h3>EVENTS</h3>
             <p><b>Find nearby events; Cure your boredom!</p>
           </div>
           <div class=\"col s4\">
            <i id=\"icon\" class=\"mdi-action-account-child\"></i>
            <h3>SOCIAL</h3>
            <p>Interact with your friends!</p>
           </div>
           <div class=\"col s4\">
            <i id=\"icon\" class=\"mdi-action-done-all\"></i>
            <h3>CREATE</h3>
            <p>Create your own events and invite people</b></p>
          </div>
      </div>
 <div class=\"css-slideshow\">
  <figure>
    <img src=\"class-header-css3.jpg\" width=\"495\" height=\"370\" />
     <figcaption><strong>CSS3:</strong> CSS3 delivers a...</figcaption>
  </figure>
  <figure>
    <img src=\"class-header-semantics.jpg\" width=\"495\" height=\"370\" />
    <figcaption><strong>Semantics:</strong> Giving meaning to...</figcaption>
  </figure>
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
