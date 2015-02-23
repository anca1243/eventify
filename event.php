<html>
  <head>
   <?php 
   echo "<title>Event ".htmlspecialchars($_GET["id"])."</title>";
   require("style/linkcss.php"); ?>
  </head>
  <body>
  <?php require("style/header.php");
  echo '<div id="content">';
  require("database.php");

  //Get vars
  $con = connect();
  $stmt = $con->prepare("SELECT * FROM Events WHERE `Id`=?");
  $stmt->bind_param('i', $_GET["id"]);
  $stmt->execute();
  $stmt->bind_result($id, $title, $location, $sdate, $edate, $desc, $postcode, $createdBy);
  $stmt->fetch();
  $sdate = date("d M y",$sdate);
  $edate = date("d M y",$edate);

  echo '<h1>'.$title.'</h1>';
  echo '<div id="EventInfo">
    <p id="evdate">';

    if ($sdate != $edate) {
      echo "From ".$sdate." to ".$edate;
    } else {
      echo "Date: ".$sdate;
    }
    echo '</p>
    <p id="evlocation">Location: '.$location.'</p>
    <p id="evpostcode">'.$postcode.'</p>
    <h4 id="evdescription">'.$desc.'</h4>
  </div>'; ?>
  </body>
</html>
