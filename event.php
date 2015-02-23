<html>
  <head>
   <?php 
   echo "<title>Event ".htmlspecialchars($_GET["id"])."</title>";
   require("style/linkcss.php"); ?>
  </head>
  <body>
  <?php require("style/header.php");
  echo '<div id="content"><h1>Event '.htmlspecialchars($_GET["id"]).'</h1>';
  require("database.php");

  //Get vars
  $con = connect();
  $stmt = $con->prepare("SELECT * FROM Events WHERE `Id`=?");
  $stmt->bind_param('i', $_GET["id"]);
  $stmt->execute();
  $stmt->bind_result($id, $title, $desc, $date, $location, $postcode);
  $stmt->fetch();
  echo '<div id="EventInfo">
    <p id="evtitle">'.$title.'</p>
    <p id="evdescription">'.$desc.'</p>
    <p id="evdate">'.$date.'</p>
    <p id="evlocation">'.$location.'</p>
    <p id="evpostcode">'.$postcode.'</p>
  </div>'; ?>
  </body>
</html>
