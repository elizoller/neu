<?php
$lat = $_POST['lat'];
$lon = $_POST['lon'];
$url = "http://api.wunderground.com/api/00d16d2057ab5cd1/geolookup/q/" . $lat . "," . $lon . ".json";
$location = file_get_contents($url);
$locationjson = json_decode($location);
echo $locationjson->location->city . ", " .  $locationjson->location->state;
?>