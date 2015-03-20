<?php
include('geoip/ip2locationlite.class.php');
function getLocation() { 
  require("geoip.conf.php");
  //Load the class
  $ipLite = new ip2location_lite;
  $ipLite->setKey($API_KEY);
  //Get user's city based on their IP addr 
  $locations = file_get_contents("http://api.ipinfodb.com/v3/ip-city/?key=32de137900caa0fa4c55e85859b44231c1f60112d0b143e0db33248e40553450&ip=".$_SERVER['REMOTE_ADDR']);
  echo $locations;
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
