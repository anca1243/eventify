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
      echo '<img src="//graph.facebook.com/'.$id.'/picture?type=large">'; 
      echo "<h1>User ";
      //Get the user's name
      echo $fbProfile['name'];
      echo "</h1>";  
      //Link to their profile 
      echo "Facebook profile: <a href='".$fbProfile['link']."'>".$fbProfile['link']."</a>";
      if (getCity($id) != "") {
        echo "<h2>Events Happening here:</h2>";
        getCreatedBy($id);
      } else {
        echo "<h2>Events " . $fbProfile['first_name'] . " is going to</h2>";
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
