<html>
 <head>
  <title>Eventify!</title>
  <?php require("style/linkcss.php"); ?>
 </head>
 <body>
  <?php require("style/header.php"); ?>
  <?php
    require("database.php");
    use Facebook\FacebookRequest;
    $id = $_GET["id"];
    $id = substr($id, 1,-1);
    if (!isset($_SESSION['session'])) {
      echo "<p>You must be logged in to view user profiles.\n <a href='index.html'>Go back to homepage</a></p>";
    } else {
      $fbProfile = fbRequest($id);
      echo '<img src="//graph.facebook.com/'.$userData["id"].'/picture?type=large">'; 
      echo "<h1>User ";
      echo $fbProfile['name'];
      echo "</h1>";   
      echo "Facebook profile: <a href='".$fbProfile['link']."'>".$fbProfile['link']."</a>";
      echo "<h2>Created events:</h2>";
      getCreatedBy($id);
    }
  ?>
 </body>
</html>