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
?>

<h1>Succesfully Logged out.</h1>
<h2>You will be redirected in <span id="counter">5</span> second(s).</h2>
<h3>If you are not, <a href='index.php'>Click here</a></h3>
<script type="text/javascript">
function countdown() {
    var i = document.getElementById('counter');
    if (parseInt(i.innerHTML)==0) {
        window.location = 'index.php';
    }
    i.innerHTML = parseInt(i.innerHTML)-1;
}
setInterval(function(){ countdown(); },1000);
</script>

