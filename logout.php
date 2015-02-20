<?php
//Clear all session variables
session_start();
session_unset();
$_SESSION['FBID'] = NULL;
$_SESSION['FULLNAME'] = NULL;
$_SESSION['EMAIL'] =  NULL;
header("Location: index.php");  ;
?>
