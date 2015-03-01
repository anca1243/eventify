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
<h2>You should be redirected in 3 seconds.</h2>
<h3>If you are not, <a href='index.php'>Click here</a></h3>
<meta http-equiv="refresh" content="3; url=index.php">

