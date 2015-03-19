<!--Import config-->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
<header>
<?php require("config.php");
      require("facebookAPI.php");
 ?>
<!--Nav bar-->
<nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="index.php" class="brand-logo"><img height="50px" src="img/eventify-logo.png"></a>
      <ul class="right hide-on-med-and-down">
        <li><a href="index.php">Home</a></li>
        <?php echo $nav_buttons; ?>
      </ul>

      <ul id="nav-mobile" class="side-nav">
        <li><a href="index.php">Home</a></li>
        <?php echo $mobile_nav_buttons; ?>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
    </div>
  </nav>


  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>
</header>
<main>
