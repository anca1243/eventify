<!--Import config-->
<?php require("config.php"); ?>
<meta charset="UTF-8"> 
<!--Nav bar-->
<div class="navbar-fixed">
<nav>
 <div class="nav-wrapper" name="navbar">
  <a href="index.php" class="brand-logo"><img src="img/eventify-logo.png" height="60"></a>
  <ul id="nav-mobile" class="right-side-nav" style="right:0px; position:absolute">
   <li>
    <a href="index.php"><i class="mdi-action-home" style="vertical-align:middle;"></i>Home</a>
   </li>
   <li>
    <a href="addevent.php"><i class="mdi-content-add" style="vertical-align:middle;"></i>Add Event</a>
   </li>
   <li>
    <a href="search.php?evtitle=&evdate=&evpostcode=&evdesc=&maxdist="><i class="mdi-action-search" style="vertical-align:middle;"></i>Search</a>
   </li>
   <li>
    <?php require("facebookAPI.php"); ?>
   </li>
  </ul>
 </div>
</nav>
</div>
    
<!--Imports-->
<script type="text/javascript" 
        src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" 
        src="js/materialize.min.js"></script>


