<?php

//start set up for YELP
require_once('OAuth.php');
$CONSUMER_KEY = 'fmntEHKHJjM_Ylw3pa6iQw';
$CONSUMER_SECRET = 'zDUmc8aAjnaJ_KYrnWyyM4Ywi40';
$TOKEN = '2muiBcvTFUm94uNsvGYdyL1M3guGS0KP';
$TOKEN_SECRET = 'qpJbceMyEBeMMbl6KtrByNppKDI';
$API_HOST = 'api.yelp.com';
$SEARCH_LIMIT = 4;
$SEARCH_PATH = '/v2/search/';
$host = 'localhost';
$path = '/~eliscottzoller/neu/api.php';
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
//end set up for Yelp

//carryin variables from form submission
$action = $_POST['action'];
$cquery = $_POST['cquery'];
$lat = $_POST['lat'];
$lon = $_POST['lon'];
$state = $_POST['state'];
$state_full = $_POST['state_full'];
$city_state = urldecode($cquery);
$pieces = explode(", ", urldecode($cquery));
$city_state = $pieces[0] . ", " . $state;
$city_state_full = $pieces[0] . ", " . $state_full;

//set up query URLs
$wiki_url_1 = "http://en.wikipedia.org/w/api.php?action=query&prop=extracts&exintro&titles=".urlencode($city_state_full)."&format=json&redirects";
$wiki_url_2 = "http://en.wikipedia.org/w/api.php?format=json&action=query&prop=info&titles=".urlencode($city_state_full)."&inprop=url&redirects";
$google_url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=" . $lat . "," . $lon . "&rankby=distance&types=amusement_park|aquarium|art_gallery|casino|campground|bowling_alley|library|movie_theater|museum|park|shopping_mall|stadium|university|zoo&key=AIzaSyDpbRqXZ8cDTRQEV4-Wm5t6V8LkY6B4QMg";
$eventful_url = "http://api.eventful.com/json/events/search?app_key=jcqqsQbhhzmpc4D3&keywords=books&location=" . $cquery . "&date=Future&sort_order=date&page_size=4";
$dpla_url = "http://api.dp.la/v2/items?q=".urlencode($city_state_full).'&api_key=b0ff9dc35cb32dec446bd32dd3b1feb7';
$flickr_url = "https://api.flickr.com/services/rest/?&method=flickr.photos.search&api_key=24ad194cceb24285045f026dff301622&text=" . urlencode($city_state) . "&safe_search=1&sort=date-taken-desc&per_page=5&format=json&nojsoncallback=1";

if ($action == 'all') {
  all();
}

function all() {
  global $cquery, $lat, $lon, $city, $state, $countrycode3, $dpla_url, $wiki_url_1, $wiki_url_2, $wunderground_url, $eventful_url, $google_url, $jamendo_url, $flickr_url, $city_state, $city_state_full;
    // build the individual requests as above, but do not execute them
  $ch_1 = curl_init($dpla_url);
  $ch_2 = curl_init($wiki_url_1);
  $ch_3 = curl_init($wiki_url_2);
  $ch_4 = curl_init($eventful_url);
  $ch_5 = curl_init($google_url);
  $ch_6 = curl_init($flickr_url);

  curl_setopt($ch_1, CURLOPT_HEADER, false);          // Don't return HTTP headers
  curl_setopt($ch_1, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch_2, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch_3, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch_4, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch_5, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch_6, CURLOPT_RETURNTRANSFER, true);

  // build the multi-curl handle, adding both $ch
  $mh = curl_multi_init();
  curl_multi_add_handle($mh, $ch_1);
  curl_multi_add_handle($mh, $ch_2);
  curl_multi_add_handle($mh, $ch_3);
  curl_multi_add_handle($mh, $ch_4);
  curl_multi_add_handle($mh, $ch_5);
  curl_multi_add_handle($mh, $ch_6);


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

  $results_dpla = json_decode($response_1);
  $results_wiki_1 = json_decode($response_2);
  $results_wiki_2 = json_decode($response_3);
  $results_eventful = json_decode($response_4);
  $results_google = json_decode($response_5);
  $results_flickr = json_decode($response_6);

  wikipedia($city_state, $results_wiki_1, $results_wiki_2);
  echo "<hr/>";
  yelp($results_yelp, $cquery, $city, $state);
  echo "<hr/><div class='row'>";
  googleplaces($results_google, $city, $state);
  eventful($cquery, $results_eventful, $city, $state);
  echo "</div>";
  echo "<hr/><div class='row'>";
  dpla($city_state, $results_dpla);
  flickr($city, $results_flickr);
  echo "</div>";
  }


 



function wikipedia($city_state, $results_wiki_1, $results_wiki_2) {
  //WIKIPEDIA RESULTS
   foreach ($results_wiki_2->query->pages as $m) {
    $wikiarticle = $m->fullurl;
    $wikimissing = $m->missing;
   }
  echo "<div class='row'><div class='col-xs-12'>";
  //if no wikipedia article
  if (isset($wikimissing) && ($wikimissing == '')) {
    echo "<p>Wikipedia doesn't have any information on " . $city_state . ". <a href='" . $wikiarticle . "' target='_blank'>Add some!</a></p>";
  }
  else {
    foreach ($results_wiki_1->query->pages as $k) {
      $extract = $k->extract;
    }
    echo "<p>" . $extract . "</p><p class='clearfix'><a target='_blank' href='" . $wikiarticle ."'>Read more from Wikipedia about " . $city_state . "</a></p>";
  }
    echo "</div></div>";
}

function yelp($results_yelp, $cquery, $city, $state) {
  $results_yelp = json_decode(search($cquery));
 //YELP RESULTS
  echo "<div class='row yelp'><h3>Eat Local</h3><div class='col-xs-12'>";
  //if no restaurants found
  if ($results_yelp->businesses == NULL) {
    echo "<p>Better luck in the next town.</p>";
  }
  else {
    foreach($results_yelp->businesses as $business) {
      echo "<div class='col-sm-3 col-xs-6'>";
      echo "<h5><a href='" . $business->url . "' target='_blank'>" . $business->name . "</a></h5>";
      if (isset($business->image_url)) {
        echo "<a href='" . $business->url . "' target='_blank'><img src='" . $business->image_url . "' class='img-thumbnail'></a>";
      }
      echo "<br/><a href='" . $business->url . "' target='_blank'><img src='" . $business->rating_img_url_small . "'></a>";
      echo "</div>";
    }
  echo "<p class='clearfix'><a href='http://yelp.com' target='_blank'><img src='http://s3-media4.fl.yelpcdn.com/assets/2/www/img/9b7b8f0fecd7/developers/Powered_By_Yelp_Yellow.png'></a><br/><a href='http://www.yelp.com/search?find_desc=Restaurants&find_loc=" . $city . "%2C+" . $state . "&ns=1' target='_blank'>Find more Restaurants on Yelp</a></p></div></div>";
  }
} 
function googleplaces($results_google, $city, $state) {
//GOOGLE PLACES RESULTS
    echo "<div class='col-sm-6'><h3>Explore Local</h3>";
    //if places listed
    if ($results_google->status == 'OK') {
      echo "<ul>";
      foreach ($results_google->results as $result) {
        echo "<li><a href='https://www.google.com/#q=" . $result->name . "' target='_blank'>" . $result->name . "</a></li>";
      }
      echo "</ul>";
    }
    else {
      echo "<p>Keep on truckin'.</p>";
    }
   echo "<p><a href='https://www.google.com/#q=" . urlencode($city . ", " . $state . " attractions") . "' target='_blank'>Look for more on Google</a><br/><img src='https://maps.gstatic.com/mapfiles/api-3/images/powered-by-google-on-white2.png'></div>";
  }
function eventful($cquery, $results_eventful, $city, $state) {
 //EVENTFUL RESULTS
    echo "<div class='col-sm-6'><h3>Coming Up</h3>";
    //if no events
    if ($results_eventful->total_items == 0) {
      echo "<p>Check back soon for more events!</p>";
    }
    else {
      echo "<ul>";
      foreach($results_eventful->events->event as $event) {
        echo "<li><a href='" . $event->url . "' target='_blank'>" . $event->title . "</a><br/>";
        echo $event->start_time . "<br/>";
        echo "at the <a href='" . $event->venue_url . "' target='_blank'>" . $event->venue_name . "</a></li>";
      }
      echo "</ul><p class='clearfix'><a href='https://www.google.com/#q=" . urlencode("upcoming events " . $city . ", " . $state) . "'>More Upcoming Events</a></p>";
    }
    echo "<div class='eventful-badge eventful-small'><img src='http://api.eventful.com/images/powered/eventful_58x20.gif' alt='Local Events, Concerts, Tickets'><p><a href='http://eventful.com/'>Events</a> by Eventful</p></div></div>";
}

function dpla($city_state, $results_dpla) {
// DPLA RESULTS
//gets count of results
$numresultsdpla = intval($results_dpla->count);
$countdpla = 0;
echo "<div class='col-sm-6'><h3>Get Historical</h3>";
//if there are results
  if ($numresultsdpla > 0) {
    foreach ($results_dpla->docs as $doc) {
      $countdpla++;
      if ($countdpla <= 5) {
        $link = $doc->isShownAt;
        $title = $doc->sourceResource->title;
        if (is_array($title)) {
          $title = $title[0];
        }
         $provider = $doc->dataProvider;
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
          echo "<div class='row'><div class='col-xs-4'><a href='".$link."' target='_blank'><img src='" . $image . "' class='dpla_image' /></a></div><div class='col-xs-8'><a href='" . $link . "' target='_blank'>" . $title . "</a><br/>" . $provider . "</div></div>";
      }
    }
      
      echo "<a href='http://dp.la/search?q=".$city_state."' target='_blank'>See full results for ".$city_state." at the Digital Public Library of America</a>";
  } else {
      echo "<p>".$city_state." returned no results from the <a href='http://dp.la' target='_blank'>Digital Public Library of America</a>.</p>";
  }
    echo "</div>"; 
}
function flickr($city, $results_flickr) {
  //FLICKR RESULTS
   echo "<div class='col-sm-6'><h3>Local Pictures</h3>";
   //if there are photos
   if ($results_flickr->photos->total != 0) {
   echo "<div class='carousel slide' id='flickr_carousel'><ol class='carousel-indicators'><li data-target='flickr_carousel' data-slide-to='0' class='active'><li data-target='flickr_carousel' data-slide-to='1'><li data-target='flickr_carousel' data-slide-to='2'><li data-target='flickr_carousel' data-slide-to='3'><li data-target='flickr_carousel' data-slide-to='4'></ol><div class='carousel-inner'>";
   $flickr_count = 0;
  foreach($results_flickr->photos->photo as $photo) {
    $flickr_count++;
    $photoid = $photo->id;
    $phototitle = $photo->title;
    $photourl = file_get_contents("https://api.flickr.com/services/rest/?&method=flickr.photos.getSizes&format=json&api_key=24ad194cceb24285045f026dff301622&photo_id=" . $photoid . "&nojsoncallback=1");
    $photojson = json_decode($photourl);

    foreach($photojson->sizes->size as $size) {
      if ($size->label == 'Medium 800') {
        $thumb = $size->source;
        $photolink = $size->url;
      } else if ($size->label == 'Medium') {
        $thumb = $size->source;
        $photolink = $size->url;
      }
    }
    echo "<div class='item";
    if ($flickr_count == 1) {
      echo " active";
    }
    echo "' data-slide-number='" . ($flickr_count - 1) . "'><img src='" . $thumb . "'><div class='carousel-caption'><a href='" . $photolink . "' target='_blank'>" . $phototitle . "</a></div></div>";
  }
  echo "</div><a class='left carousel-control' href='#flickr_carousel' role='button' data-slide='prev'><span class='glyphicon glyphicon-chevron-left'></span></a><a class='right carousel-control' href='#flickr_carousel' role='button' data-slide='next'><span class='glyphicon glyphicon-chevron-right'></span></a></div>";
  }
  else {
    echo "<p>Come back later for pictures from " . $city;
  }
  echo "<p class='clearfix'>Powered by <a href='http://flickr.com'>Flickr</a></p></div>";
}
?>