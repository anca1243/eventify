<?php
/**
* Querying against GeoIP/Lite City
* This will fetch country along with city information
*/
 
include("geoip/geoipcity.inc");
include("geoip/geoipregionvars.php");
 
$giCity = geoip_open("geoip/GeoLiteCity.dat",GEOIP_STANDARD);
 
$ip = $_SERVER['REMOTE_ADDR'];
$record = geoip_record_by_addr($giCity, $ip);
 
echo "Getting Country and City detail by IP Address <br /><br />";
 
echo "IP: " . $ip . "<br /><br />";
 
echo "Country Code: " . $record->country_code .  "<br />" .
"Country Code3: " . $record->country_code . "<br />" .
"Country Name: " . $record->country_name . "<br />" .
"Region Code: " . $record->region . "<br />" .
"Region Name: " . $GEOIP_REGION_NAME[$record->country_code][$record->region] . "<br />" .
"City: " . $record->city . "<br />" .
"Postal Code: " . $record->postal_code . "<br />" .
"Latitude: " . $record->latitude . "<br />" .
"Longitude: " . $record->longitude . "<br />" .
"Metro Code: " . $record->metro_code . "<br />" .
"Area Code: " . $record->area_code . "<br />" ;  
 
geoip_close($giCity);
?>
