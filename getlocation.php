<?php
$lat = $_POST['lat'];
$lon = $_POST['lon'];
$url = "http://geoservices.tamu.edu/Services/ReverseGeocoding/WebService/v04_01/Rest/?lat=" . urlencode($lat) . "&lon=" . urlencode($lon) . "&apikey=ba6cfbbc044e4f369804f8c4c01672ae&format=json&notStore=false&version=4.01";
$location = file_get_contents($url);
$locationjson = json_decode($location);
foreach ($locationjson->StreetAddresses as $place) {
	echo $place->City . ", " . $place->State;
}
?>