<html>
 <head>
  <title>Eventify!</title>
  <?php require("style/linkcss.php"); ?>
 </head>
 <body>
  <!-- Easy import of header -->
  <?php require("style/header.php");
        require("database.php"); ?>
  <h1>Welcome to eventify</h1>
  
  <h3>Alpha v0.0.2</h3>
  <h4>Events happening today, <?php echo date('d M y'); ?></h4> 
  <?php
   $results = search_events("", "", date('d M y'), "", "");
   displayResults($results);
  ?>

 <?php require("style/footer.php"); ?>
 </body>
</html>
