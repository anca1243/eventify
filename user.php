<html>
 <head>
  <title>Eventify!</title>
  <?php require("style/linkcss.php"); ?>
 </head>
 <body>
  <?php require("style/header.php"); ?>
  <?php
    $id = $_GET["id"];
    $id = substr($id, 1,-1);
    if (!isset($_SESSION['session'])) {
      echo "<p>You must be logged in to view user profiles.\n <a href='index.html'>Go back to homepage</a></p>";
    } else {
      $session = $_SESSION['session'];
      echo "<img src='//graph.facebook.com/".$id."/picture?type=large'>";
    }
  ?>
 </body>
</html>
