<html>
  <head>
   <?php 
   echo "<title>Event Info</title>";
   require("style/linkcss.php"); ?>
  </head>
  <body>
  <?php require("style/header.php");
  echo '<div id="content">';
  require("database.php");
  //Get variables
  $con = connect();
  $stmt = $con->prepare("SELECT * FROM Events WHERE `Id`=?");
  $stmt->bind_param('i', $_GET["id"]);
  $stmt->execute();
  $stmt->bind_result($id, $title, $location, $sdate, $edate, $desc, $postcode, $createdBy);
  $stmt->fetch();
  $sdate = date("d M y",$sdate);
  $edate = date("d M y",$edate);
  if ($postcode == "City Centre") { $postcode .= ", ".getCity($createdBy); 
                                    $location .= ", ".getCity($createdBy); 
  }
  echo '<h1>'.$title.'</h1>';
  echo '<div id="EventInfo">
    <div class="row">
    <div class="col s4">

    <h5 id="evdate">';

    if ($sdate != $edate) {
      echo "From ".$sdate." to ".$edate;
    } else {
      echo "Date: ".$sdate;
    }
    $user = fbRequest($createdBy);
    echo '</h5><br>
    <h5 id="evlocation">Location: '.$location.'</h5><br>
    <h5 id="createdBy">Created by <a href=user.php?id="'.$createdBy.'">
           '.$user['name'].'</a></h5></p><br>'; 
    if( $postcode != "Various" )
    {
      echo'</div><div class="col s4 offset-s2">
      <iframe
        width="600"
        height="450"
        frameborder="0" style="border:0"
        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBvFEWYa4AoCrM2NImuEgff5JDs4Nt360g&q='.$postcode.'">
      </iframe>';
    } else {
      echo'</div><div class="col s4 offset-s2">
      <iframe
        width="600"
        height="450"
        frameborder="0" style="border:0"
        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBvFEWYa4AoCrM2NImuEgff5JDs4Nt360g&q='.getCity($createdBy).'">
      </iframe>';
    }
    echo
    '</div></div><h5 id="evdescription">'.$desc.'</h5>
  </div>'; ?>
  <?php require("style/footer.php"); ?>
  </body>
</html>
