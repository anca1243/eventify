<html>
 <head>
  <title>Event created</title>
   <?php require("style/linkcss.php"); ?>
  </title>
 </head>

 <body>
  <?php require("style/header.php");
        require("database.php");
        //require("dates.php");
  ?>
  <?php
    echo "<h1>Event Succesfully Created</h1>";
    $title = $_POST["evtitle"];
    $desc  = $_POST["evdescription"];
    $sdate = $_POST["evsdate"];
    $edate = $_POST["evedate"];
    $loc   = $_POST["evlocation"];
    $post  = $_POST["evpostcode"];
       
    //Set up databse connection
    $database_host = $group_dbnames[0];
    $database_user  = $group_dbnames[2];
    $database_pass = $group_dbnames[3];
    $database_name = $group_dbnames[1];
    
    //Connect to the database
    $con = connect();
    $stmt = $con->prepare("INSERT INTO Events (`name`, `location`, `startDate`, `endDate`, 
                           `description`,`postcode`,`createdBy`) VALUES (?,?,?,?,?,?,?);");
    if (!$stmt) {
      echo $con->error;
    }
    $dates = array($sdate,$edate);
    $formattedDates = stringToDateUser($dates);
    //Post the event
    $stmt->bind_param("sssssss",$title,$loc,$formattedDates[0],$formattedDates[1],$desc,$post,$_SESSION["id"]);
    $stmt->execute();
    echo "<p>The event has been posted! <a href=index.php>Return home</a></p>";
  ?>
 </body>

</html>
