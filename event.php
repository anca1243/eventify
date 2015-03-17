<html lang="en">
  <head>
   <meta property="fb:app_id" content="837275619665461" />
   <?php 
   echo "<title>Eventify!</title>";
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
  
  echo "<br>";
  echo '<div class="row">
          <div class="container">';
  if (!goingToEvent($_GET['id'])) 
    echo "<form method='post' action='userAddEvent.php'>
          <input name='id' type='hidden' value='".$_GET['id']."'>
          <button type='submit' action='userAddEvent.php' class='right btn waves-effect waves-light'><i class='mdi-content-add'></i>I'm going!</button>";
  else echo "<form method='post' action='userRmEvent.php'><input name='id' type='hidden' value='".$_GET['id']."'>
             <button type='submit' action='userRmEvent.php' class='right btn waves-effect waves-light'><i class='mdi-content-remove'></i>
            I'm not going any more</button>";
  echo "</form>"; 
  echo '</div>
        </div>';

  echo '<div id="index-banner" class="parallax-container">
          <div class="section no-pad-bot">
            <div class="container">
              <br><br>
              <h1 class="header center blue-text">'.$title.'</h1>
              <div class="row center">
                <h5 id="evdate" class="header col s12 light">';
                if ($sdate != $edate) {
                  echo "From ".$sdate." to ".$edate;
                } else {
                  echo "Date: ".$sdate;
                }
                $user = fbRequest($createdBy);
                echo '</h5>
              </div>
            </div>
          </div>
        </div>';
  echo '<div class="container" id="EventInfo">
      <div class="section">
        <div class="row">
          <div class="col s12 m6">
          <br><br><br><br>
            <h5 class="header center light" id="evlocation">Location: '.$location.'</h5><br>
            <h5 class="header center light" id="createdBy">Created by <a href=user.php?id="'.$createdBy.'">
           '.$user['name'].'</a></h5><br>';
   
    if( $postcode != "Various" )
    {
      echo'</div><div class="col s12 m6">
      <iframe
        width="600"
        height="450"
        frameborder="0" style="border:0"
        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBvFEWYa4AoCrM2NImuEgff5JDs4Nt360g&q='.$location.'">
      </iframe>';
    } else {
      echo'</div><div class="col s12 m6">
      <iframe
        width="600"
        height="450"
        frameborder="0" style="border:0"
        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBvFEWYa4AoCrM2NImuEgff5JDs4Nt360g&q='.getCity($createdBy).'">
      </iframe>';
    }
    echo
    '</div></div></div>';
    echo '<h5 class="flow-text" id="evdescription">'.$desc.'</h5>';
    echo '<div class="row">
    <div class="col s12 m12">
    <div class="eventGoers">';
    $con = connect();
    $stmt = $con->prepare("SELECT * FROM UserEvents WHERE `EventID`=?;");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $results = array();
    echo '<ul class="collection with-header">';
    echo '<li class="collection-header"><h4 class="header light">Attending:</h4></li>';
    while ($row = $result->fetch_assoc()) {
      $name = getName($row['userID']);
      echo '<li class="collection-item "><div class="container">
      <h5 class="header light"><img src="//graph.facebook.com/'.$row['userID'].'/picture" alt="" class="circle"><span class="title">'.$name.'</span>
      <a href="user.php?id=\''.$row['userID'].'\'" class="secondary-content"><i class="mdi-content-send"></i></a></h5></div></li>';
    } 
  echo "</ul>";    
  echo '</div></div></div>';
  echo '<br><br>
        <h5 class="header light"> If you have already been to this event plase leave a comment and tell us how it was!</h5>';
   echo '<fb:comments href="'.$url.'event.php?id='.$_GET["id"].'"></fb:comments>
</div>'; ?>
  <?php require("style/footer.php"); ?>
  </body>
</html>
