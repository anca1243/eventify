<?php
include('geoip/ip2locationlite.class.php');
function getLocation() { 
  require_once("geoip.conf.php");
  //Load the class
  $ipLite = new ip2location_lite;
  $ipLite->setKey($API_KEY);
 
  $locations = $ipLite->getCity($_SERVER['REMOTE_ADDR']);
  $errors = $ipLite->getError();
  return $locations;

}

?>
