<html>
 <head>
  <title>Event created</title>
   <?php require("style/linkcss.php"); ?>
  </title>
 </head>

 <body>
  <?php require("style/header.php"); ?>
  <?php
    echo "<h1>Event Succesfully Created</h1>";
    $title = $_POST["evtitle"];
    $desc  = $_POST["evdescription"];
    $date  = $_POST["evdate"];
    $loc   = $_POST["evlocation"];
    $post  = $_POST["evpostcode"];
       
    //Set up databse connection
    $database_host = $group_dbnames[0];
    $database_user  = $group_dbnames[2];
    $database_pass = $group_dbnames[3];
    $database_name = $group_dbnames[1];
  
    echo "Connection made";

    //Connect to the database
    $con = new mysqli($database_host,$database_user,$database_pass,$database_name);
    $stmt = $con->prepare("INSERT INTO Events (`name`, `location`, `date`, `description`,`postcode`) VALUES (?,?,?,?,?);");
    $stmt->bind_param("sssss",$title,$loc,$date,$desc,$post);
    $stmt->execute();
  ?>
 </body>

</html>
