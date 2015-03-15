<html>
 <head>
  <title>Eventify!</title>
  <?php require("style/linkcss.php"); ?>
 </head>
 <body>
  <?php require("style/header.php"); ?>
  <?php
    require("database.php");
    require("geoIP.php");
    use Facebook\FacebookRequest;
    $id = $_GET["id"];
    //Because the url ID is formatted with quote marks
    $id = substr($id, 1,-1);
    //Must be logged in
    if (!isset($_SESSION['session'])) {
      echo "<p>You must be logged in to view user profiles.\n <a href='index.php'>Go back to homepage</a></p>";
    } else {
      //Place the user's photo on the page
      $fbProfile = fbRequest($id);
      echo '<div class="row">';
      echo '<div class="col s4">';
      echo "<h1>";
      //Get the user's name
      echo $fbProfile['name'];
      echo "</h1>";  
      echo '</div><div class="col s4 offset-s4 fb-photo">';
      echo '<img src="//graph.facebook.com/'.$id.'/picture?type=large">'; 
      echo '</div></div>';
      //Link to their profile      
      if (getCity($id) != "") {
        echo "<h2>Events Happening here:</h2>";
        getCreatedBy($id);
      } else {
        if ($_SESSION['id'] == $id) {
          echo '<h4>This is you!</h4>';
        }
        else if (!following($id)) {
        echo '<form action="unfollow.php" method="post">
              <input type="hidden" value="'.$id.'"></input>
              <button type="submit" class="btn waves-effect waves-light">
              Follow '.$fbProfile['name'].'
             <i class="mdi-content-add right"></i></button></form>';
        } else {
        echo '<form action="follow.php" method="post">
              <input type="hidden" value="'.$id.'"></input>
              <button type="submit" class="btn waves-effect waves-light">
              Unfollow '.$fbProfile['name'].'
             <i class="mdi-content-remove right"></i></button></form>';

        }
        echo "<h2>Events " . $fbProfile['name'] . " is going to:</h2>";
        $con = connect();
        $stmt = $con->prepare("SELECT * FROM Events,UserEvents WHERE Events.id = UserEvents.EventID AND UserEvents.userID = ?");
        $stmt->bind_param('s', $_SESSION["id"]);
        $stmt->execute();     
        $result = $stmt->get_result(); 
        $results = array();
	while ($row = $result->fetch_assoc()) {
            array_push($results, $row);
        }
	displayResults($results);
 	
  
      }
    }
  ?>
 <?php require("style/footer.php"); ?>
 </body>
</html>
