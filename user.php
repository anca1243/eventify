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
      echo '<div id="index-banner" class="parallax-container">
              <div class="section no-pad-bot">
                <div class="container">
                  <br><br>
                  <h2 class="header center blue-text">You must be logged in to view user profiles.</h2>
                  <div class="row center">
                    <h5 class="header col s12 light"><a href="index.php">Go back to homepage</a></h5>
                  </div>
                  <div class="row center">
                    <a href="chooselogin.php" id="download-button" class="btn-large waves-effect waves-light blue">Get started!</a>
                  </div>
                  <br>
                </div>
              </div>
            </div>';
    } else {
      $fbProfile = fbRequest($id);
      echo '<div id="index-banner" class="parallax-container">
              <div class="section no-pad-bot">
                <div class="container">
                  <br><br>
                  <h1 class="header center blue-text">'.$fbProfile['name'].'</h1>
                  <div class="row center">
                    <img src="//graph.facebook.com/'.$id.'/picture?type=large"" class="circle responsive-img">
                  </div>
                  <br><br><br>
                </div>
              </div>
            </div>';
      //Link to their profile      
      if (getCity($id) != "") {
        echo '<div class="container">
                    <br><br>
                    <div class="row left">
                      <h4 class="header col s12 light">Events happening here: </h4>
                    </div>
                    <br>
              </div>';
        getCreatedBy($id);
      } else {
        if ($_SESSION['id'] == $id) {
          echo '';
        }
        else if (!following($id)) {
        echo '<div class ="container">
              <form action="unfollow.php" method="post">
              <input type="hidden" value="'.$id.'"></input>
              <button type="submit" class="btn waves-effect waves-light">
              Follow '.$fbProfile['name'].'
             <i class="mdi-content-add right"></i></button></form>
             </div>';
        } else {
        echo '<div class="container">
              <form action="follow.php" method="post">
              <input type="hidden" value="'.$id.'"></input>
              <button type="submit" class="btn waves-effect waves-light">
              Unfollow '.$fbProfile['name'].'
             <i class="mdi-content-remove right"></i></button></form>
             </div>';

        }
        echo '<div id="content" class="container">
                <div class="row left">
                  <h5 class="header col s12 light">Events ' . $fbProfile['name'] . ' is going to:</h5>
                </div>
                <div class="row">
                  <div class="col s12">';
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
 	      echo '</div>
              </div>
              </div>';
  
      }
    }
  ?>
 <?php require("style/footer.php"); ?>
 </body>
</html>
