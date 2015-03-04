<?php
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
    echo "<script>$(document).ready(function() {
          $('#searchResults tr').click(function() {
          var href = $(this).find('a').attr('href');
          if(href) {
            window.location = href;
          }
          });});</script>";

    //Runs through the search results and displays them
    echo "<p>Distance from ".getLocation()['zipCode']."
    <a href='postcode.php'>Not your location?</a></p>";
    echo "<table class='hoverable' id='searchResults'>
            <thead>
             <tr>
              <th data-field='name'>Title</th>
              <th data-field='desc'>Description</th>
              <th data-field='sdate'>Start Date</th>
              <th data-field='edate'>End Date</th>
              <th data-field='loc'>Location</th>"; 
	      echo "<th data-field='dist'>Distance</th>";
    echo "</tr>
        </thead>

        <tbody>";
   //Run through all results and format them in the table
   foreach ($a as $row) {

     echo "<tr>";
     echo "<td><a href=event.php?id=".$row['id'].">".$row['name']."</td>";
     $desc = explode("\n",$row['description']);
     echo "<td>".$desc[0]."</td>";
     echo "<td>".date("d M y",$row['startDate'])."</td>";
     echo "<td>".date("d M y",$row["endDate"])."</td>";
     echo "<td>".$row['postcode']."</td>";
     if (isset($row[0]))  
       echo "<td>".$row[0]."</td>";
     echo "</tr></a>";
   }
   echo "</tbody>
         </table>"; 
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
    $url ="http://maps.googleapis.com/maps/api/distancematrix/json?origins=";
    $url .= urlencode($postcode1)."&destinations=";
    //Go through all results from the query
    while ($row = $result->fetch_assoc()) {
        $postcode2 = ($row['postcode']);
        //If there is a valid postcode associated with the row, add it to our google query.
	if (preg_match($regex, $postcode2 )) {
          $url .= urlencode("|".$postcode2);
        }
        //Placeholder for distance values
      	array_push($row, "---");
	//Add row to our results
      	array_push($results, $row);
    }
    //Set the units to miles.
    //There's no real reason, most people just use miles
    $url .= "&units=imperial";
    //Read the response from google
    $data = file_get_contents($url);
    //It's in JSON format, decode
    $result1 = json_decode($data);
    //It's quite a long response, we'll just use the bit we need
    $distance = ($result1->rows[0]->elements);
    $returnValues = array();
    foreach ($results as $row) {
        //For all results with a valid postcode, add the distance
   	if (preg_match($regex, $row['postcode'])) {
		$row[0] = $distance[0]->distance->text;
                //If the user has set a maximum distance, check this against the result
		if (!no_val($maxdist))  {
		  if ($row[0] <= $maxdist)
                    array_push($returnValues, $row);
                } else {
                    //Otherwise just push it anyways
		    array_push($returnValues, $row);
		}
		//Delete the first element from google results
		array_shift($distance);
	} else {
		//Not a valid postcode, if user doesn't care about distance, add it.
		if (no_val($maxdist)) 
			array_push($returnValues, $row);
	}
		       
    }
    //Throw back the array of all results
    return $returnValues;
  }
  //Get the list of events created by user with ID $id;
  function getCreatedBy($id) {
    displayResults(search_events("","","","","","",$id));
  }
  ?>
