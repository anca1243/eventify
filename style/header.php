<!--Import config-->
<?php require("config.php"); ?>
<meta charset="UTF-8"> 
<!--Nav bar-->
<div class="navbar-fixed">
<nav>
 <div class="nav-wrapper" name="navbar">
  <a href="index.php" class="brand-logo">Eventify</a>
  <ul id="nav-mobile" class="right-side-nav">
   <li>
    <a href="index.php"><i class="mdi-action-home"></i>Home</a>
   </li>
   <li>
    <a href="addevent.php"><i class="mdi-content-add"></i>Add Event</a>
   </li>
   <li>
    <a href="search.php"><i class="mdi-action-search"></i>Search</a>
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


