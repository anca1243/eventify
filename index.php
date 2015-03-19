<!DOCTYPE html>
<html lang="en">
<head>
  <?php
	function not_in($a, $b) {
          foreach ($b as $c) {
            if ($c['userID'] == $a['userID'])
              if ($c['eventID'] == $a['eventID'])
                return False;
          }
          return True;
         }
  ?>

  <title>Eventify!</title>

  <!-- CSS  -->
<?php require ("style/linkcss.php"); 
      require ("database.php"); ?>
</head>
<body>
<?php require ("style/header.php"); ?>
  <div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container">
        <br><br>
       	 <?php
		if (isset($_SESSION['id'])) {
			$id = $_SESSION['id'];
			//Display Logged in homepage
			echo  '<h1 class="header center blue-text">
				Welcome Back!
			       </h1>
                               <div class="row center">
                                <h5 class="header col s12 light">
				What\'s been happening recently?
				</h5>';
				
			$con = connect();
    			$stmt = $con->prepare("SELECT * 
					       FROM `UserEvents` 
                           		       INNER JOIN UserFollows 						  ON UserEvents.userID = ?
                           OR (UserEvents.userID = UserFollows.User2 
                           AND UserFollows.User1 = ?)
                         ");
                        $stmt->bind_param("ss",
                                          $id,
                                          $id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $results = array();
                        while ($row = $result->fetch_assoc()) {
                        if (not_in($row, $results))
                          array_push($results, $row);
                        }
			$goingTo =  array_reverse($results); 						
	
    $con = connect();
    $stmt = $con->prepare("SELECT * FROM UserFollows WHERE User1 = ? OR User2=?;");
    $stmt->bind_param("ss", $id, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $results = array();
    while ($row = $result->fetch_assoc()) {
     array_push($results, $row);
    }
    $follows =  array_reverse($results);
    for ($i = 0; $i < 5; $i++) {
      echo '<div class="row">';
      echo '<div class="col s6">';
      echo '<p class="left-align">';
      if (@$goingTo[$i]['userID'] != NULL) {
      $uID = $goingTo[$i]['userID'];
      echo '<i class="mdi-hardware-keyboard-tab"></i>
            &nbsp&nbsp'.getName($uID).' '.
            ((getName($uID) == "You")?"are":"is").' 
            going to <a href="event.php?id='.$goingTo[$i]['eventID']
	    .'">'.getEvent($goingTo[$i]['eventID'])['name']."</a>";
      }
      echo '</p>';
      echo '</div>';
      echo '<div class="col s6">';
      echo '<p class="right-align">';
      if (@$follows[$i]['User1'] != NULL) {
        $row = $follows[$i];
        echo  getName($row['User1'])." followed ".
              getName($row['User2']).
              "&nbsp&nbsp
              <i class=\"mdi-social-person-add\"></i></p>";
      }
      echo '</p>';
      echo '</div>';
      echo '</div>';
    }
 
	echo '</div>
              </div>
                               <div class="row center">
                                <a href="search.php?evtitle=&evdate=&evpostcode=&evdesc=&maxdist=&city=" id="download-button" 
                                class="btn-large waves-effect waves-light blue">Find Events!</a>';

		} else{
			//Display welcome page
			echo  '<h1 class="header center blue-text">Welcome to Eventify!</h1>
		               <div class="row center">
          			<h5 class="header col s12 light">An easy-to-use collection of event from all over UK</h5>
        		       </div>
        		       <div class="row center">
				<a href="chooselogin.php" id="download-button" 
				class="btn-large waves-effect waves-light blue">Get started!</a>';
		}
        ?>
	</div>
      </div>
    </div>
  </div>


  <div class="container">
    <div class="section">

      <!--   Icon Section   -->
      <div class="row">
        <div class="col s12 m4">
          <div class="icon-block">
            <h4 class="center">Liverpool</h4>
            <p class="center light">Liverpool’s famous attractions include the Albert Dock, the UK’s oldest Chinatown, St. George’s Hall, the Walker Art Gallery and a Beatles-themed museum.</p>
            <div class="row center">
              <a href="search.php?evtitle=&evdate=&evpostcode=&evdesc=&maxdist=&city= <?php echo Cities::LIVERPOOL; ?>#content" id="download-button" class="btn waves-effect waves-light blue">Look for events!</a>
            </div>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h4 class="center">Manchester</h4>

            <p class="center light">There is more to Manchester than football, music and rain. As the world’s first industrial city Manchester has a rich history and had a big impact on shaping the world we live in today.</p>
            <div class="row center">
              <a href="search.php?evtitle=&evdate=&evpostcode=&evdesc=&maxdist=&city=<?php echo Cities::MANCHESTER; ?>#content" id="download-button" class="btn waves-effect waves-light blue">Look for events!</a>
            </div>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h4 class="center">Sheffield</h4>

            <p class="center light">The Sheffield Ski Village is one of the largest artificial ski resorts in Europe. The city also has the largest theatre complex outside London and is the home of many electronic rock groups.</p>
            <div class="row center">
              <a href="search.php?evtitle=&evdate=&evpostcode=&evdesc=&maxdist=&city=<?php echo Cities::SHEFFIELD; ?>#content" id="download-button" class="btn waves-effect waves-light blue">Look for events!</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br><br>
</div>


  </body>
<?php require ("style/footer.php"); ?>
</html>
