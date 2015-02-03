<?php
  //Set up databse connection
  $database_host = $group_dbnames[0];
  $database_user  = $group_dbnames[2];
  $database_pass = $group_dbnames[3];
  $database_name = $group_dbnames[1];
  
  function connect() {
    $con = new mysqli($database_host,$database_user,$database_pass,$database_name);
    return $con;
  }

  function search_events($name, $location, $date, $desc, $postcode) {
    $con = connect();
    //Allows for easy SQL generation
    if (!isset($name)) $name = "%";
    if (!isset($location)) $name = "%";
    if (!isset($date)) $name = "%";
    if (!isset($desc)) $name = "%";
    if (!isset($postcode)) $name = "%";
    $stmt = $con->prepare("SELECT * FROM Events WHERE `name`=? AND `location`=? AND
                           `date`=? AND `description`=? AND `postcode`=?");
    $stmt->bind_param('sssss', $name, $location, $date, $description, $postcode);
    $stmt->execute();
    //$stmt->bind_result($id, $title, $desc, $date, $location, $postcode);
    $result = $stmt->fetch_all();
    $rows = array();
    foreach ($result as $row) {
      $row->bind_result($id, $title, $desc, $date, $location, $postcode);
      echo row;
    }
  }
  
?>
