<?php
//Oauth set up for Yelp
require_once('OAuth.php');
$CONSUMER_KEY = 'fmntEHKHJjM_Ylw3pa6iQw';
$CONSUMER_SECRET = 'zDUmc8aAjnaJ_KYrnWyyM4Ywi40';
$TOKEN = '2muiBcvTFUm94uNsvGYdyL1M3guGS0KP';
$TOKEN_SECRET = 'qpJbceMyEBeMMbl6KtrByNppKDI';
$API_HOST = 'api.yelp.com';
$SEARCH_LIMIT = 3;
$SEARCH_PATH = '/v2/search/';
$host = 'localhost';
$path = '/~eliscottzoller/pres/dpla/results.php';
//http://localhost/~eliscottzoller/pres/dpla/index3.php
function request($host, $path) {
	$unsigned_url = "http://" . $host . $path;
	$token = new OAuthToken($GLOBALS['TOKEN'], $GLOBALS['TOKEN_SECRET']);
	$consumer = new OAuthConsumer($GLOBALS['CONSUMER_KEY'], $GLOBALS['CONSUMER_SECRET']);
	$signature_method = new OAuthSignatureMethod_HMAC_SHA1();
	$oauthrequest = OAuthRequest::from_consumer_and_token(
		$consumer,
		$token,
		'GET',
		$unsigned_url
		);
	$oauthrequest->sign_request($signature_method, $consumer, $token);
	$signed_url = $oauthrequest->to_url();
	$ch = curl_init($signed_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    
    return $data;
}
function search($cquery) {
	$url_params = array();
	$url_params['term'] = 'restaurant';
	$url_params['location'] = $cquery;
	$url_params['limit'] = $GLOBALS['SEARCH_LIMIT'];
	$search_path = $GLOBALS['SEARCH_PATH'] . "?" . http_build_query($url_params);
	return request($GLOBALS['API_HOST'], $search_path);
}



//rest of the searches
if(!empty($_POST['q']) && isset($_POST['append'])){
	$query = $_POST['q'];
  	$cquery = str_replace(' ', '+', $query);
  	$cquery = str_replace('?', '%26', $cquery);
  	$cquery = str_replace('&', '%3F', $cquery);
  	//$encode = urlencode(utf8_encode($cquery));

		 $lat = $_POST['lat'];
  		 $lon = $_POST['lon'];
	if ($lat == NULL || $lon == NULL){
  		 //using geonames to get lat, long, country code, state, and city parsed
		$locationfile = file_get_contents("http://api.geonames.org/postalCodeSearchJSON?placename=" . $cquery . "&maxRows=1&username=elizoller");
		//echo $locationfile;
		$locationfile = json_decode($locationfile);
		foreach($locationfile->postalCodes as $place){
			$lat = $place->lat;
			$lon = $place->lng;
			$country = $place->countryCode;
			$city = $place->placeName;
			$state = $place->adminCode1;
			//echo $lat . $lon . $country . $city . $state;
		}

	} else {
		$locationfile = file_get_contents("http://api.geonames.org/postalCodeSearchJSON?placename=" . $cquery . "&maxRows=1&username=elizoller");
		//echo $locationfile;
		$locationfile = json_decode($locationfile);
		foreach($locationfile->postalCodes as $place){
			$country = $place->countryCode;
			$city = $place->placeName;
			$state = $place->adminCode1;
			//echo $lat . $lon . $country . $city . $state;
		}
	}

		//to get iso3 country code, needed for jamendo
 		$countryfile = file_get_contents("http://api.worldbank.org/countries/" . $country . "?format=json");
 		$countrycode = json_decode($countryfile);
 		foreach($countrycode as $country) {
 			foreach($country as $thiscountry) {
 				$countrycode3 =  $thiscountry->id;
 			} 			
 		}

  $url = "http://api.dp.la/v2/items?q=".$cquery.'&api_key=b0ff9dc35cb32dec446bd32dd3b1feb7';
  $dburl = "http://en.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exchars=300&titles=".$cquery;
  $wikiurl = "http://en.wikipedia.org/w/api.php?action=query&prop=info&titles=".$cquery."&inprop=url&format=json";
  $wurl = "http://autocomplete.wunderground.com/aq?query=" . $cquery;
  $eurl = "http://api.eventful.com/json/events/search?app_key=jcqqsQbhhzmpc4D3&keywords=books&location=" . $cquery . "&date=Future&sort_order=date&page_size=3";
  $gurl = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=" . $lat . "," . $lon . "&rankby=distance&types=amusement_park|aquarium|art_gallery|casino|campground|bowling_alley|library|movie_theater|museum|park|shopping_mall|stadium|university|zoo&key=AIzaSyAnpCEFofOkoTJLEXJZc4O4qpDT3YFgkJI";
  $jurl = "http://api.jamendo.com/v3.0/artists/locations?client_id=25e87652&format=jsonpretty&limit=5&haslocation=true&location_country=" . $countrycode3 . "&location_city=" . $city;
  $furl = "https://api.flickr.com/services/rest/?&method=flickr.photos.search&api_key=24ad194cceb24285045f026dff301622&lat=" . $lat . "&lon=" . $lon . "&safe_search=1&sort=date-taken-desc&per_page=5&format=json&nojsoncallback=1";

}else{
  echo "Please enter a location";
  }
  //echo $gurl;
//getting wunderground url
 $filecontents = file_get_contents($wurl);
 $filecontents = json_decode($filecontents);
   foreach ($filecontents->RESULTS as $resultw) {
    	$wundergroundurl = $resultw->l;
    }
      $wuurl = "http://api.wunderground.com/api/00d16d2057ab5cd1/conditions" . $wundergroundurl.".json";
     
  // with curl_multi, you only have to wait for the longest-running request
  
  // build the individual requests as above, but do not execute them
  $ch_1 = curl_init($url);
  $ch_2 = curl_init($dburl);
  $ch_3 = curl_init($wikiurl);
  $ch_4 = curl_init($wuurl);
  $ch_5 = curl_init($eurl);
  $ch_6 = curl_init($gurl);
  $ch_7 = curl_init($jurl);
  $ch_8 = curl_init($furl);

  curl_setopt($ch_1, CURLOPT_HEADER, false);          // Don't return HTTP headers
  curl_setopt($ch_1, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch_2, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch_3, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch_4, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch_5, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch_6, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch_7, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch_8, CURLOPT_RETURNTRANSFER, true);

  // build the multi-curl handle, adding both $ch
  $mh = curl_multi_init();
  curl_multi_add_handle($mh, $ch_1);
  curl_multi_add_handle($mh, $ch_2);
  curl_multi_add_handle($mh, $ch_3);
  curl_multi_add_handle($mh, $ch_4);
  curl_multi_add_handle($mh, $ch_5);
  curl_multi_add_handle($mh, $ch_6);
  curl_multi_add_handle($mh, $ch_7);
  curl_multi_add_handle($mh, $ch_8);


  // execute all queries simultaneously, and continue when all are complete
  $running = null;
  do {
    curl_multi_exec($mh, $running);
  } while ($running);
  
  // all of our requests are done, we can now access the results
  $response_1 = curl_multi_getcontent($ch_1);
  $response_2 = curl_multi_getcontent($ch_2);
  $response_3 = curl_multi_getcontent($ch_3);
  $response_4 = curl_multi_getcontent($ch_4);
  $response_5 = curl_multi_getcontent($ch_5);
  $response_6 = curl_multi_getcontent($ch_6);
  $response_7 = curl_multi_getcontent($ch_7);
  $response_8 = curl_multi_getcontent($ch_8);


  $resultdpla = json_decode($response_1);
  $resultsdb = json_decode($response_2);
  $resultswiki = json_decode($response_3);
  $resultsw = json_decode($response_4);
  $resultsy = json_decode(search($cquery));
  $resultse = json_decode($response_5);
  $resultsg = json_decode($response_6);
  $resultsj = json_decode($response_7);
  $resultsf = json_decode($response_8);


// get number of results
$numresultsdpla = intval($resultdpla->count);
$countdpla = 0;
if ($numresultsdpla > 0) {
  echo 'Your search for "'.$query.'" returned '.$numresultsdpla.' results. Results 1-10:';
  echo '<table border="0" cellspacing="3">';
  foreach ($resultdpla->docs as $doc) {
  // for each result, show an image, a title, and have both link to the item in DPLA
  // also show name of institution (dataProvider), but no link
    $count++;
    if ($count <= 5) {
      $link = $doc->isShownAt;
      $title = $doc->sourceResource->title;
	  $provider = $doc->dataProvider;
      // sometimes I find an array in the title node - this will grab the first title
      if (is_array($title)) {
        $title = $title[0];
      }
      // sometimes I find an array in the provider node - this will grab the first provider
      if (is_array($provider)) {
        $provider = $provider[0];
      }
      // if there is an image, it's here
      if (isset($doc->object)) {
        $image = $doc->object;
      }
      // if not, show placeholder image
      if (!(isset($image))) {
        $image = "http://dp.la/assets/icon-text.gif";
      }
      // display item
		    echo '<tr><td><a href="'.$link.'" target="_blank"><img src="' . $image . '" width="55" /></a></td><td><a href="' . $link . '" target="_blank">' . $title . '</a><br />' . $provider . '</td></tr>';
      }
    }
    echo '</table>';
    // provide link to jump out to DPLA search, including query
    echo '<a href="http://dp.la/search?q='.$query.'" target="_blank">See full results for your query "'.$cquery.'" at the Digital Public Library of America</a>';
  } else {

  // no results case. If no results, return error message. Also include a null response for the initial condition, pre-query.
  if (isset($cquery)) {
    echo '<div id="dpla_search_results_dcplumer">Your search for "'.$query.'" returned no results. Please search again.</div>';
  } else {
    echo ' ';
  }
  }

  //WIKIPEDIA RESULTS NOW
   foreach ($resultswiki->query->pages as $m) {
   	$wikiarticle = $m->fullurl;
   }
  echo '<table border="0" cellspacing="3">';
  foreach ($resultsdb->query->pages as $k) {
  	$extract = $k->extract;
  }
 	echo '<tr><th>' . $cquery . '</th></th></tr><tr><td>' . $extract . '</td></tr><tr><td><a target="_blank" href="' . $wikiarticle .'">Read more from Wikipedia about ' . $cquery . '</a></td></tr>';
    echo '</table>';

 //WEATHER UNDERGROUND RESULTS
   echo "Current Weather in " . $cquery . "<br/>";
   		$weatherimg = $resultsw->current_observation->icon_url;
   		echo "<img src='" . $weatherimg . "'>";
   		echo "<br/>Feels like " . $resultsw->current_observation->feelslike_f;
   		echo "<br/><a href='" . $resultsw->current_observation->forecast_url . "' target='_blank'>See the full forecast</a>";

 //YELP RESULTS
   		//echo search($cquery);
   	foreach($resultsy->businesses as $business) {
   		echo "<h4><a href='" . $business->url . "' target='_blank'>" . $business->name . "</a></h4>";
   		echo $business->rating;
   		echo "<br/><img src='" . $business->image_url . "'>";
   	}

 //EVENTFUL RESULTS
   	echo "<br/>Upcoming Events in " . $cquery . "<br/>";
   	foreach($resultse->events->event as $event) {
   		echo $event->title . "<br/>";
   		echo $event->start_time . "<br/>";
   		echo "at the <a href='" . $event->venue_url . "' target='_blank'>" . $event->venue_name . "</a><br/><br/>";
   	}

//GOOGLE PLACES
   	echo "<br/>Nearby Attractions<br/>";
   	foreach ($resultsg->results as $result) {
   		echo "<a href='https://www.google.com/#q=" . $result->name . "' target='_blank'>" . $result->name . "</a><br/>";
   	}

//JAMENDO   
	echo "<br/>Musicians from " . $city . "<br/>";	
	//echo $response_7;
	foreach($resultsj->results as $band) {
		if ($band->website == NULL) {
			$bandurl = $band->shorturl;
		} else {
			$bandurl = $band->website;
		}
		echo "<a href='" . $bandurl . "' target='_blank'>" . $band->name . "</a>";
		echo "<br/><img src='" . $band->image . "'><br/><br/>";
	}
//FLICKR
	echo "Pictures from " . $city . "<br/>";
	//echo $response_8;
	//echo $resultsf->photos->total;
	foreach($resultsf->photos->photo as $photo) {
		$photoid = $photo->id;
		//echo $photoid;
		$phototitle = $photo->title;
		$photourl = file_get_contents("https://api.flickr.com/services/rest/?&method=flickr.photos.getSizes&format=json&api_key=24ad194cceb24285045f026dff301622&photo_id=" . $photoid . "&nojsoncallback=1");
		//echo $photourl;
		$photojson = json_decode($photourl);
		//$thumb = $photojson->sizes[0]->canblog;
		//		echo $thumb;

		foreach($photojson->sizes->size as $size) {
			//echo $size->label . " : " . $size->url . "<br/>";
			if ($size->label == 'Small') {
				$thumb = $size->source;
			}
		}
		echo "<img src='" . $thumb . "'>" . $phototitle . "<br><br>";
	}

  ?>