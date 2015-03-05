<!--Import config-->
<header>
<?php require("config.php"); ?>
<meta charset="UTF-8"> 
<!--Nav bar-->
<div class="navbar">
<nav>
  <ul id="slide-out" class="side-nav fixed">
   <li><a href="index.php" class="brand-logo"><img src="img/eventify-logo.png" height="60"></a>
   </li>
   </br>
   <hr>
   <li>
    <a href="index.php"><i class="mdi-action-home" style="vertical-align:middle;"></i><p>Home</p></a>
   </li>
    <li>
    <a href="search.php?evtitle=&evdate=&evpostcode=&evdesc=&maxdist=&city="><i class="mdi-action-search" style="vertical-align:middle;"></i><p>Search</p></a>
   </li>
   <li>
    <?php require("facebookAPI.php"); ?>
   </li>
  </ul>
</nav>
</div>

<div class="content"> 
<!--Imports-->
<script type="text/javascript" 
        src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" 
        src="js/materialize.min.js"></script>
<script>
    $(".button-collapse").sideNav();
</script>
</header>
<main>
<body>
