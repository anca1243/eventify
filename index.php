<html>
 <head>
  <title>Eventify!</title>
  <?php require("style/linkcss.php"); ?>
 </head>
 <body>
  <!-- Easy import of header -->
  <?php require("style/header.php"); ?>
  <h1>Welcome to eventify</h1>
  <h2>This is an alpha version of the site, functionality can and will change</h2>
  <h3>Alpha v0.0.1</h3>
  <?php
   $results = search_events("", "", date('d M y'), "", "");
   displayResults($results);
  ?>

 <?php require("style/footer.php"); ?>
 </body>
</html>
