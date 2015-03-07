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
    $con = connect();
    $stmt = $con->prepare("SELECT * FROM `UserEvents` 
                           INNER JOIN UserFollows 
                           ON UserEvents.userID = ?
                           OR (UserEvents.userID = UserFollows.User2 
                           AND UserFollows.User1 = ?)
                         ");
    $stmt->bind_param("ss",$_SESSION['id'], $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $results = array();
    while ($row = $result->fetch_assoc()) {
         if (not_in($row, $results))
           array_push($results, $row);
    }    echo '<div class="activity-feed">';
    echo '<div class="row">';
    echo '<div class="col s8">';
    //Going to new event
    foreach (array_reverse(array_slice($results, sizeof($results)-10)) as $row) {
      echo '<br><i class="mdi-hardware-keyboard-tab"></i>&nbsp&nbsp'.getName($row['userID']).' '.
            ((getName($row['userID']) == "You")?"are":"is").' going to <a href="event.php?id='.$row['eventID'].'">'.getEvent($row['eventID'])['name']."</a><br>";
    }
    echo '</div>';
    $con = connect();
    $stmt = $con->prepare("SELECT * FROM UserFollows WHERE User1 = ? OR User2=?;");
    $stmt->bind_param("ss", $_SESSION['id'], $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $results = array();
    while ($row = $result->fetch_assoc()) {
     array_push($results, $row);
    }
    echo '<div class="col s4">';
    foreach (array_reverse(array_slice($results, sizeof($results)-10)) as $row) {
      echo '<br><i class="mdi-social-person-add"></i>&nbsp&nbsp'.getName($row['User1'])." followed ".getName($row['User2'])."<br>";
    }
    echo '</div>';
  }

  function not_in($a, $b) {
    foreach ($b as $c) {
     if ($c['userID'] == $a['userID'])
       if ($c['eventID'] == $a['eventID'])
         return False;
    }
    return True;
  }
 ?>

 <?php require("style/footer.php"); ?>
</html>
