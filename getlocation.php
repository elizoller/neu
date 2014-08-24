<?php
$lat = $_POST['lat'];
$lon = $_POST['lon'];
$url = "http://api.geonames.org/findNearbyPlaceNameJSON?lat=" . urlencode($lat) . "&lng=" . urlencode($lon) . "&username=elizoller";
$location = file_get_contents($url);
$locationjson = json_decode($location);
foreach ($locationjson->geonames as $name) {
	echo $name->toponymName . ", " . $name->adminCode1;
}
?>