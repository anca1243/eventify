<?php
include('geoip/ip2locationlite.class.php');
function getLocation() { 
  require("geoip.conf.php");
  //Load the class

  //Get user's city based on their IP addr 
  $locations = curl_init("http://api.ipinfodb.com/v3/ip-city/?key=32de137900caa0fa4c55e85859b44231c1f60112d0b143e0db33248e40553450&ip=".$_SERVER['REMOTE_ADDR']);
  curl_setopt($locations, CURLOPT_RETURNTRANSFER, true);
  $locs = curl_exec($locations);
  curl_close($locations);
  $locations = explode(";",$locs);
  
  foreach ($locations as $l) {
    if (preg_match('#^(GIR ?0AA|[A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]([0-9ABEHMNPRV-Y])?)|[0-9][A-HJKPS-UW]) ?[0-9][ABD-HJLNP-UW-Z]{2})$#', $l)) {
       $locations["zipCode"] = $l;
  }
}
  if (!isset($locations["zipCode"]))
    $locations["zipCode"] = "M13 9PL";
  //See if the user has manually set their postcode
  if (isset($_SESSION['postcode']))
    $locations['zipCode'] = $_SESSION['postcode'];
  //Throw back the user's location
  return $locations;

}

?>
