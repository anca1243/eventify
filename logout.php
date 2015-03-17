<?php

require("style/header.php");
echo "<head>";
require("style/linkcss.php");
echo "</head>";
//Clear all session variables
session_unset();
$_SESSION['FBID'] = NULL;
$_SESSION['FULLNAME'] = NULL;
$_SESSION['EMAIL'] =  NULL;
$_SESSION['session'] = NULL;
$_SESSION['postcode'] = NULL;
$_SESSION['li'] = NULL;
$_SESSION['kiosk'] = false;
?>

<div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container">
        <br><br>
        <h1 class="header center blue-text">Successfully logged out!</h1>
        <div class="row center">
          <h5 class="header col s12 light">You will be redirected in <span id="counter">5</span> seconds</h5>
        </div>

        <div class="row center progress">
            <div class="indeterminate"></div>
        </div>
        
        <div class="row center">
          <h6 class="header col s12 light">If you don't get redirected, <a href="index.php">Click here</a></h6>
        </div>
        <br>
      </div>
    </div>
</div>

<?php require ("style/footer.php"); ?>
<script type="text/javascript">
function countdown() {
    var i = document.getElementById('counter');
    if (parseInt(i.innerHTML)==0) {
        window.location = 'index.php';
    }
     if (parseInt(i.innerHTML)>0)
    i.innerHTML = parseInt(i.innerHTML)-1;
}
setInterval(function(){ countdown(); },1000);
</script>

