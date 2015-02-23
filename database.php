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
    echo "<table class='hoverable' id='searchResults'>
            <thead>
             <tr>
              <th data-field='name'>Title</th>
              <th data-field='desc'>Description</th>
              <th data-field='sdate'>Start Date</th>
              <th data-field='edate'>End Date</th>
              <th data-field='loc'>Location</th>
            </tr>
        </thead>

        <tbody>";
   foreach ($a as $row) {

     echo "<tr>";
     echo "<td><a href=event.php?id=".$row['id'].">".$row['name']."</td>";
     $desc = explode("\n",$row['description']);
     echo "<td>".$desc[0]."</td>";
     echo "<td>".date("d M y",$row['startDate'])."</td>";
     echo "<td>".date("d M y",$row["endDate"])."</td>";
     echo "<td>".$row['postcode']."</td></tr>";
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

  function search_events($name, $location, $date, $desc, $postcode) {
    $con = connect();
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
    if (!$stmt = $con->prepare($sql)) { echo "SQL incorrect or injection attempt."; die; }
    if (!$stmt->execute()) { echo "Query Failed"; die; }
    $result = $stmt->get_result();
    $results = array();
    while ($row = $result->fetch_assoc()) {
        array_push($results, $row);
    }
    return $results;
  }
  //Get the list of events created by user with ID $id;
  function getCreatedBy($id) {
    $con = connect();
    $stmt = $con->prepare("SELECT * FROM Events WHERE `createdBy` = ?");
    $stmt->bind_param("s",$id);
    if (!$stmt->execute()) { echo "Query Failed"; die; }
    $result = $stmt->get_result();
    $results = array();
    while ($row = $result->fetch_assoc()) {
        array_push($results, $row);
    }
    displayResults($results);

  }
  ?>
