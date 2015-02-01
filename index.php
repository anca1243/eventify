<html>
 <head>
  <title>Eventify!</title>
  <?php require("style/linkcss.php"); ?>
 </head>
 <body>
  <?php require("style/header.php"); ?>
  <h1>Welcome to eventify</h1>
  <h2>This is an alpha version of the site, functionality can and will change</h2>
  <h3>Alpha v0.0.1</h3>
  <?php
    echo "<div id='satan'>";
    for ($i = 1; $i <= 10; $i++) {
      echo "<marquee class='satan' scrollamount='".($i*10)."'><h1 class='satan'>IT WAS THE SLASH</h1>/SLASH/SLASH//:(/<img src='http://www.godandscience.org/images/devil.jpg'></marquee>";
    }
    echo "</div>";
  ?>
 </body>
</html>
