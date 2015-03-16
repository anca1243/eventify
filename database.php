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
    echo "<script>$(document).ready(function() {
          $('#searchResults tr').click(function() {
          var href = $(this).find('a').attr('href');
          if(href) {
            window.location = href;
          }
          });});
          var asc0 = 1;
          var asc1 = 1;
          var asc2 = 1;
          var asc3 = 1;
          var asc4 = 1;
          var asc5 = 1;
          </script>";

    //Runs through the search results and displays them
    echo "<h5>Distance from ".getLocation()['zipCode']."&nbsp&nbsp<a href='postcode.php'>Not your location?</a></h5>";
    //Make th elements clickable for sorting
    echo "<table class='hoverable' id='searchResults'>
            <thead>
             <tr>
              <th data-field='name' onclick =\"sort_table(searchResultsBody, 0, asc0);
              asc0 *= -1; asc2 = 1; asc3 = 1; asc4 = 1; asc5 = 1;\" >Title<i class='mdi-content-sort'></i></th>
              <th data-field='sdate' onclick =\"sort_table(searchResultsBody, 2, asc2); 
              asc0 = 1; asc2 *= -1; asc3 = 1; asc4 = 1; asc5 = 1;\" >Start Date<i class='mdi-content-sort'></i></th>
              <th data-field='edate' onclick =\"sort_table(searchResultsBody, 3, asc3); 
              asc0 = 1; asc2 = 1; asc3 *= -1; asc4 = 1; asc5 = 1;\">End Date<i class='mdi-content-sort'></i></th>
              <th data-field='loc'>Location</th> 
              <th data-field='dist' onclick =\"sort_table(searchResultsBody, 5, asc5); 
              asc0 = 1; asc2 = 1; asc3 = 1; asc4 = 1; asc5 *= -1;\">Distance<i class='mdi-content-sort'></i></th>
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
   <script>
    function sort_table(tbody, col, asc)
     {
       var rows = tbody.rows, events = new Array();
       //Fill the array
       for(var event = 0; event < rows.length; event++)
       {
         events[event] = new Array();
         var info = rows[event].cells;
         for(var infopart = 0; infopart < info.length; infopart++)
         {
           events[event][infopart] = info[infopart].innerHTML;
         }
       }
       events.sort(function(ev1, ev2)
                {
                  if (col == 2 || col == 3) {
                   return (ev1[col] == ev2[col]) ? 0 : ((Date.parse(ev1[col]) > Date.parse(ev2[col])) ? asc : -1*asc);
                  }
                  return (ev1[col] == ev2[col]) ? 0 : ((ev1[col] > ev2[col]) ? asc : -1*asc);
                });
       //Rebuuild events table
       for(var event = 0; event < rows.length; event++)
       {
         events[event] = '<td>' + events[event].join('</td><td>')+'</td>';
       }
       tbody.innerHTML = '<tr>' + events.join('</tr><tr>')+'</tr>'; 
     }
 
   </script>";
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
    $distances = array();
    $num = 0;
    while ($row = $result->fetch_assoc()) {
        $url .= urlencode("|".$row['location']);
        $num += 1;
        if (strlen($url) >= 1500) {
          $url .= "&units=imperial";
          if (@$data = (file_get_contents($url))) {
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
           $url ="http://maps.googleapis.com/maps/api/distancematrix/json?origins=";
           $url .= urlencode($postcode1)."&destinations=";
         }  else {
		  $url ="http://maps.googleapis.com/maps/api/distancematrix/json?origins=";
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
    else
      return fbRequest($id)['name'];
  }

  ?>
