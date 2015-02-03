<html>
  <head>
   <?php 
   echo "<title>Event ".htmlspecialchars($_GET["id"])."</title>";
   require("style/linkcss.php"); ?>
  </head>
  <body>
  <?php require("style/header.php");
  echo '<div id="content"><h1>Event '.htmlspecialchars($_GET["id"]).'</h1>';

  //Set up databse connection
  $database_host = $group_dbnames[0];
  $database_user  = $group_dbnames[2];
  $database_pass = $group_dbnames[3];
  $database_name = $group_dbnames[1];

  //Get vars
  $con = new mysqli($database_host,$database_user,$database_pass,$database_name);
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
