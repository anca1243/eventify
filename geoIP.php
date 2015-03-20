<?php
include('geoip/ip2locationlite.class.php');
function getLocation() { 
  require("geoip.conf.php");
  //Load the class
  $ipLite = new ip2location_lite;
  $ipLite->setKey($API_KEY);
  //Get user's city based on their IP addr 
  $locations = $ipLite->getCity($_SERVER['REMOTE_ADDR']);
  //Detect errors (does not handle)
  $errors = $ipLite->getError();
  print_r($errors);
  //See if the user has manually set their postcode
  if (isset($_SESSION['postcode']))
    $locations['zipCode'] = $_SESSION['postcode'];
  //Throw back the user's location
  return $locations;

}

?>
