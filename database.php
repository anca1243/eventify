<?php
  //Set up databse connection
  require("dates.php"); 
  function connect() {
    require("config.php");
    $database_host = $group_dbnames[0];
    $database_user  = $group_dbnames[2];
    $database_pass = $group_dbnames[3];
    $database_name = $group_dbnames[1];
    $con = new mysqli($database_host,$database_user,$database_pass,$database_name);
    return $con;
  }

  function no_val($a) {
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
    echo "(Distance from ".getLocation()['zipCode'].")\n";
    echo "<p><a href='postcode.php'>Not your location?</a></p>";
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

  function getTerms($a) {
    $words = explode(" ", $a);
    $return = "%".$words[0]."%'";
    $words = array_slice($words, 1);
    foreach ($words as $w) {
      $return.=" OR `description` LIKE '%".$w."%' ";
    }
    return $return;
  }

  function search_events($name, $location, $date, $desc, $postcode,$maxdist,$id) {
    $con = connect();
    require_once("geoIP.php");
    //Allows for easy SQL generation
    $sql = "SELECT * FROM Events WHERE 1=1 ";
    if (!no_val($name)) $sql.= " AND `name` LIKE '%".mysqli_real_escape_string($con, $name)."%'";
    if (!no_val($location)) $sql.= " AND `location`LIKE '%".mysqli_real_escape_string($con, $location)."%'";
    if (!no_val($date))  {
                           $sDate = stringToDate($date);
                           $sql.= " AND `startDate` <=".$sDate[0]." AND `endDate` >=".$sDate[1];
    } 
    if (!no_val($desc))  $sql.= " AND (`description` LIKE '".getTerms($desc).")";
    if (!no_val($postcode))  $sql.= " AND `postcode`LIKE '%".mysqli_real_escape_string($con, $postcode)."%'";
    if (!no_val($id)) $sql .= " AND `createdBy` = " . $id;
    if (!$stmt = $con->prepare($sql)) { echo "SQL incorrect or injection attempt."; die; }
    if (!$stmt->execute()) { echo "Query Failed"; die; }
    $result = $stmt->get_result();
    $results = array();

    $regex = '#^(GIR ?0AA|[A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]';
    $regex .= '([0-9ABEHMNPRV-Y])?)|[0-9][A-HJKPS-UW]) ?[0-9]';
    $regex .= '[ABD-HJLNP-UW-Z]{2})$#';

    $postcode1 = urlencode(getLocation()['zipCode']);
    $url ="http://maps.googleapis.com/maps/api/distancematrix/json?origins=";
    $url .= urlencode($postcode1)."&destinations=";
    
    while ($row = $result->fetch_assoc()) {
        $postcode2 = ($row['postcode']);
	if (preg_match($regex, $postcode2 )) {
          $url .= urlencode("|".$postcode2);
        }
      	array_push($row, "---");
      	array_push($results, $row);
    }
    $url .= "&units=imperial";
    $data = file_get_contents($url);
    $result1 = json_decode($data);
    $distance = ($result1->rows[0]->elements);
    $returnValues = array();
    foreach ($results as $row) {
	if (preg_match($regex, $row['postcode'])) {
		$row[0] = $distance[0]->distance->text;
		if (!no_val($maxdist))  {
		  if ($row[0] <= $maxdist)
                    array_push($returnValues, $row);
                } else {
		    array_push($returnValues, $row);
		}
		array_shift($distance);
	} else {
		if (no_val($maxdist)) 
			array_push($returnValues, $row);
	}
		       
    }
    return $returnValues;
  }
  //Get the list of events created by user with ID $id;
  function getCreatedBy($id) {
    displayResults(search_events("","","","","","",$id));
  }
  ?>
