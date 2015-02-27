<html>
 <head>
  <title>Eventify!</title>
  <?php require("style/linkcss.php"); ?>
 </head>
 <body>
  <!-- Easy import of header -->
  <?php require("style/header.php");
        require("database.php");
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

          </div>";
  } else {
    require("geoip.php");
    $user = fbRequest("/me");
    echo "Welcome back, ".$user['first_name']. " ".$user['last_name'];
    $location = getLocation();
    echo "Your location: ".$location['zipCode'];
    echo "<h4>Events happening today, ". date('d M y') ."</h4>"; 
    $results = search_events("", "", date('d M y'), "", "");
    displayResults($results);
  }
 ?>
 <?php require("style/footer.php"); ?>
 </body>
</html>
