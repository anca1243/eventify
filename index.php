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
				</h5>
				<div class="row">
					<div class="col s6">';
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
			foreach (array_reverse(
					array_slice(
						$results, 
						sizeof($results)-5)) 				      as $row) {
    echo '<br><i class="mdi-hardware-keyboard-tab"></i>&nbsp&nbsp'.getName($row['userID']).' '.
            ((getName($row['userID']) == "You")?"are":"is").' going to <a href="event.php?id='.$row['eventID'].'">'.getEvent($row['eventID'])['name']."</a><br>";
    }
				echo'	</div>
					<div class="col s6">';
		
	$con = connect();
    $stmt = $con->prepare("SELECT * FROM UserFollows WHERE User1 = ? OR User2=?;");
    $stmt->bind_param("ss", $id, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $results = array();
    while ($row = $result->fetch_assoc()) {
     array_push($results, $row);
    }
    foreach (array_reverse(array_slice($results, sizeof($results)-10)) as $row) {
      echo '<br><i class="mdi-social-person-add"></i>&nbsp&nbsp'.getName($row['User1'])." followed ".getName($row['User2'])."<br><br>";
    }
 			echo '	</div>
				</div>
                               </div>
                               <div class="row center">';
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
              <a href="search.php?evtitle=&evdate=&evpostcode=&evdesc=&maxdist=&city= <?php echo Cities::LIVERPOOL; ?>" id="download-button" class="btn waves-effect waves-light blue">Look for events!</a>
            </div>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h4 class="center">Manchester</h4>

            <p class="center light">There is more to Manchester than football, music and rain. As the world’s first industrial city Manchester has a rich history and had a big impact on shaping the world we live in today.</p>
            <div class="row center">
              <a href="search.php?evtitle=&evdate=&evpostcode=&evdesc=&maxdist=&city=<?php echo Cities::MANCHESTER; ?>" id="download-button" class="btn waves-effect waves-light blue">Look for events!</a>
            </div>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h4 class="center">Sheffield</h4>

            <p class="center light">The Sheffield Ski Village is one of the largest artificial ski resorts in Europe. The city also has the largest theatre complex outside London and is the home of many electronic rock groups.</p>
            <div class="row center">
              <a href="search.php?evtitle=&evdate=&evpostcode=&evdesc=&maxdist=&city=<?php echo Cities::SHEFFIELD; ?>" id="download-button" class="btn waves-effect waves-light blue">Look for events!</a>
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
