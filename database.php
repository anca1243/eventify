<?php
  require("enum.php"); 
  //Set up databse connection
  require("dates.php"); 
  function connect() {
    //Import configuration
    require("config.php");
    //Set connection variables
    $database_host = $group_dbnames[0];
    $database_user  = $group_dbnames[2];
    $database_pass = $group_dbnames[3];
    $database_name = $group_dbnames[1];
    //Connect to the database
    $con = new mysqli($database_host,$database_user,$database_pass,$database_name);
    return $con;
  }

  //To determine whether POST values have been set
  function no_val($a) {
    //Returns true if $a is empty
    if ($a == "") return true;
    return false;
  }

  function displayResults($a) {
    //Make all rows clickable
    //Runs through the search results and displays them

    echo "<h6 header col s12 light>Distance from ".getLocation()['zipCode']."&nbsp&nbsp<a href='postcode.php'>Not your location?</a></h6>";
    //Make th elements clickable for sorting
    echo " <br><br><div id='pager1' class='pager'>
         <form>
               <div class='row'>
                 <div class='col s2'>Results Per Page:</div>
                 <div class='col s2'>
                <select class=\"pagesize\">
                        <option selected=\"selected\"  
                        value=\"10\">10</option>
                        <option value=\"20\">20</option>
                        <option value=\"30\">30</option>
                        <option  value=\"40\">40</option>
                </select>
                </div>
	   	</div>
                <img src=\"img/ic_chevron_left_grey600_18dp.png\" 
                class=\"first\"/>
                <img src=\"img/ic_arrow_back_grey600_18dp.png\" 
                class=\"prev\"/
                <input type=\"text\" class=\"pagedisplay\"/>
                <img src=\"img/ic_arrow_forward_grey600_18dp.png\" 
                class=\"next\"/>
                <img src=\"img/ic_chevron_right_grey600_18dp.png\" 
                class=\"last\"/>

        </form>
         </div>
           <table class='tablesorter hoverable striped ' id='searchResults'>
            <thead>
             <tr>
              <th data-field='name'>Title</th>
              <th data-field='sdate' >Start Date</th>
              <th data-field='edate'>End Date</th>
              <th data-field='loc'>Location</th> 
              <th data-field='dist'>Distance</th>
              <th data-field='going'>Add/Remove</th>";
    echo "</tr>
        </thead>

        <tbody id=\"searchResultsBody\">";
 
   //Run through all results and format them in the table
   foreach ($a as $row) {

     echo "<tr>";
     echo "<td><a href=event.php?id=".$row['id'].">".$row['name']."</td>";
     echo "<td>".date("d M y",$row['startDate'])."</td>";
     echo "<td>".date("d M y",$row["endDate"])."</td>";
     echo "<td>".$row['location']."</td>";
     if (isset($row[0]))  
       echo "<td>".$row[0]."</td>";
     else
       echo '<td></td>'; 
   echo "<td>";
   if (!goingToEvent($row['id']))
     if (!isset($_SESSION['id']))
        echo "<form method='post' action='chooselogin.php'><input name='id' type='hidden' value='".$row['id']."'>
                                        <button type='submit' action='userAddEvent.php' class='btn waves-effect waves-light'><i class='mdi-social-person-add'></button>";

     else echo "<form method='post' action='userAddEvent.php'><input name='id' type='hidden' value='".$row['id']."'>
                                        <button type='submit' action='userAddEvent.php' class='btn waves-effect waves-light'><i class='mdi-content-add'></button>";
   else echo "<form method='post' action='userRmEvent.php'><input name='id' type='hidden' value='".$row['id']."'>
              <button type='submit' action='userRmEvent.php' class='btn waves-effect waves-light'><i class='mdi-content-remove'></button>";
   echo "</form></td>";
   echo "</tr></a>";
   }
   echo "</tbody>
         </table>
         <div id='pager' class='pager'>
         <form>

		<img src=\"img/ic_chevron_left_grey600_18dp.png\" class=\"first\"/>
		<img src=\"img/ic_arrow_back_grey600_18dp.png\" class=\"prev\"/
		<input type=\"text\" class=\"pagedisplay\"/>
		<img src=\"img/ic_arrow_forward_grey600_18dp.png\" class=\"next\"/>
		<img src=\"img/ic_chevron_right_grey600_18dp.png\" class=\"last\"/>
		<select class=\"pagesize\">
			<option selected=\"selected\"  value=\"10\">10</option>
			<option value=\"20\">20</option>
			<option value=\"30\">30</option>
			<option  value=\"40\">40</option>
		</select>
	</form>
         </div>
         </div>";
}
  //Function for description field - splits them into individual terms
  function getTerms($a) {
    //Split $a on spaces
    $words = explode(" ", $a);
    //% is wildcard - can match anything
    $return = "%".$words[0]."%'";
    $words = array_slice($words, 1);
    foreach ($words as $w) {
      //Eg for "Hello world"
      //The query will match Hello OR World
      $return.=" OR `description` LIKE '%".$w."%' ";
    }
    return $return;
  }

  //Search the database for events matching arguments
  function search_events($name, $location, $date, $desc, $postcode,$maxdist,$id) {
    //Connect to the database
    $con = connect();
    //Import geoIP to find distance to events
    require_once("geoIP.php");
    //Allows for easy SQL generation
    $sql = "SELECT * FROM Events WHERE 1=1 ";
    //For each argument, append to the SQL if it is set (black magic, but it works)
    // --HACKY-- //
    if (!no_val($name)) $sql.= " AND `name` LIKE '%".mysqli_real_escape_string($con, $name)."%'";
    if (!no_val($location)) $sql.= " AND `location`LIKE '%".mysqli_real_escape_string($con, $location)."%'";
    if (!no_val($date))  {
                           $sDate = stringToDate($date);
                           $sql.= " AND `startDate` <=".$sDate[0]." AND `endDate` >=".$sDate[1];
    } 
    if (!no_val($desc))  $sql.= " AND (`description` LIKE '".getTerms($desc).")";
    if (!no_val($postcode))  $sql.= " AND `postcode`LIKE '%".mysqli_real_escape_string($con, $postcode)."%'";
    if (!no_val($id)) $sql .= " AND `createdBy` = " . $id;
    //prepare the statement to be run
    //If this fails, either you have made a mistake editing this glorious code
    //Or there's malicious input
    if (!$stmt = $con->prepare($sql)) { echo "SQL incorrect or injection attempt."; die; }
    //Run the query. Stop all PHP if we can't for any reason
    if (!$stmt->execute()) { echo "Query Failed"; die; }
    //Retrieve the results
    $result = $stmt->get_result();
    $results = array();
    //Postcode regular expression
    //Provided by the government, so should work 100% of the time
    $regex = '#^(GIR ?0AA|[A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]';
    $regex .= '([0-9ABEHMNPRV-Y])?)|[0-9][A-HJKPS-UW]) ?[0-9]';
    $regex .= '[ABD-HJLNP-UW-Z]{2})$#';
    //Get thbe user's location for distance calculations
    $postcode1 = urlencode(getLocation()['zipCode']);
    //Prepare the google maps API 
    $url ="https://maps.googleapis.com/maps/api/distancematrix/json?origins=";
    $url .= urlencode($postcode1)."&destinations=";
    //Go through all results from the query
    $distances = array();
    $num = 0;
    while ($row = $result->fetch_assoc()) {
        $url .= urlencode("|".$row['location']);
        $num += 1;
        if (strlen($url) >= 1500) {
          $url .= "&units=imperial";
          $google = curl_init($url);
          curl_setopt($google, CURLOPT_RETURNTRANSFER, true);
          $data = curl_exec($google);
          curl_close($google);
          if ($data) {
            $data = json_decode($data);
            if ($data->status == "OK") 
              foreach ($data->rows[0]->elements as $dist) {
	        if ($dist->status == "OK") {
		  array_push($distances, $dist->distance->text);
                } else
                  array_push($distances, "---");
              } if (@sizeof($data->rows[0]->elements < $num)) {
		   for ($i = 0; $i < $num; $i++) array_push($distances, "---");
	      }
           $url ="https://maps.googleapis.com/maps/api/distancematrix/json?origins=";
           $url .= urlencode($postcode1)."&destinations=";
         }  else {
		  $url ="https://maps.googleapis.com/maps/api/distancematrix/json?origins=";
                  $url .= urlencode($postcode1)."&destinations=";
                  for ($i = 0; $i < $num; $i++) array_push($distances, "---");
	    }
	  $num = 0;
       }
          
        //Placeholder for distance values
      	array_push($row, "---");
	//Add row to our results
      	array_push($results, $row);
    }
    //Set the units to miles.
    //There's no real reason, most people just use miles
    $url .= "&units=imperial";
    $returnValues = array();
    foreach ($result as $row) {
	   @array_push($row, $distances[0]);
            if (!no_val($maxdist)) {
              if ($row[0] <= $maxdist) {
                @array_push($returnValues, $row);
              }
           } else {
             @array_push($returnValues, $row);
           }
            //Delete the first element from google results
	   $distances = array_slice($distances, 1);		       
    }
    //Throw back the array of all results
    
    return $returnValues;
  }
  //Get the list of events created by user with ID $id;
  function getCreatedBy($id) {
    displayResults(search_events("","","","","","",$id));
  }

  function getEvent($id) {
    $con = connect();
    $stmt = $con->prepare("SELECT * FROM Events WHERE `id`=?;");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $results = array();
    while ($row = $result->fetch_assoc()) {
      array_push($results, $row);
    }
    return $results[0];
  }

  function goingToEvent($id) {
    if (!isset($_SESSION['id'])) $id = -1;
    $con = connect();
    $stmt = $con->prepare("SELECT * FROM UserEvents WHERE EventID =? AND UserID = ?;");
    $stmt->bind_param("is", $id, $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $results = array();
    while ($row = $result->fetch_assoc()) {
      array_push($results, $row);
    }
    return (sizeof($results) != 0);

  }

  function following($id) {
    $con = connect();
    $stmt = $con->prepare("SELECT * FROM UserFollows WHERE User1 =? AND User2 = ?;");
    $stmt->bind_param("ss", $_SESSION['id'], $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $results = array();
    while ($row = $result->fetch_assoc()) {
      array_push($results, $row);
    }
    return (sizeof($results) != 0);

  }

  function getName($id) {
    if ($id == $_SESSION['id']) return "You";
    else if ($id != NULL)
      return "<a href ='user.php?id=\"{$id}\"'>".fbRequest("/".$id)['name']."</a>";
  }

  ?>
