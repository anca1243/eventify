<html>
  <head>
    <title>Event search</title>
    <?php require("style/linkcss.php"); ?>
  </head>

  <body>
    <?php require("style/header.php"); ?>
    <div id="content">
      <?php
        //Run the search, import database common
        require("database.php");
        //Retrieve vars
        $name = $_GET['evtitle'];
        $date  = $_GET['evdate'];
        $post  = $_GET['evpostcode'];
        //For the database
        $description=$_GET['evdesc'];
        $location="";
        $results = search_events($name, $location, $date, $description, $post);
        displayResults($results);
     ?>
    </div>
  </body>
</html>
