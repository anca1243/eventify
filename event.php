<html>
  <head>
   <meta property="fb:app_id" content="837275619665461" />
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
    if (!goingToEvent($_GET['id'])) 
       echo "<form method='post' action='userAddEvent.php'>
             <input name='id' type='hidden' value='".$_GET['id']."'>
             <button type='submit' action='userAddEvent.php' class='btn waves-effect waves-light'><i class='mdi-content-add'></i>I'm going!</button>";
    else echo "<form method='post' action='userRmEvent.php'><input name='id' type='hidden' value='".$_GET['id']."'>
               <button type='submit' action='userRmEvent.php' class='btn waves-effect waves-light'><i class='mdi-content-remove'></i>
               I'm not going any more</button>";
   
   echo "</form>"; 
   echo '<fb:comments href="'.$url.'event.php?id='.$_GET["id"].'"></fb:comments>';     
    if( $postcode != "Various" )
    {
      echo'</div><div class="col s4 offset-s2">
      <iframe
        width="600"
        height="450"
        frameborder="0" style="border:0"
        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBvFEWYa4AoCrM2NImuEgff5JDs4Nt360g&q='.$location.'">
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
    <div class="row">
    <div class="col s4">
    <div class="eventGoers">';
    $con = connect();
    $stmt = $con->prepare("SELECT * FROM UserEvents WHERE `EventID`=?;");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $results = array();
    echo '<ul class="collection with-header">';
    echo '<li class="collection-header"><h4>Going to this event:</h4></li>';
    while ($row = $result->fetch_assoc()) {
      $name = getName($row['userID']);
      echo '<li class="collection-item"><div>'.$name.'
      <a href="user.php?id=\''.$row['userID'].'\'" class="secondary-content"><i class="mdi-content-send"></i></a></div></li>';
    } 
    
  echo '</div></div></div></div>'; ?>
  <?php require("style/footer.php"); ?>
  </body>
</html>
