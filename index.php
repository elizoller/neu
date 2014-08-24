<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="bootstrap/css/style.css">
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
<script src="bootstrap/dist/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fluid">
<div class="row">
  <h2><a href="index.php">The Best of Local: Discover What's Around You</a></h2>
</div>
<div class="row searchbox">
  <div class="col-md-6 col-md-offset-3">
  
  <form name="search" method="post" action="results.php" role="form">
    <div class="form-group form-group-lg">  
      <div class="col-xs-8">
        <input type="text" name="q" placeholder="Where are you?" id="city" class="form-control input-lg">
      </div>
      <input type="hidden" name="lat" id="lat">
      <input type="hidden" name="lon" id="lon">
      <div class="col-xs-4">
       <button onclick="getLocation()" class="btn btn-info" type="button"><span class="glyphicon glyphicon-map-marker"></span></button>
        <input type="submit" name="submit" value="Go" class="btn btn-success btn-lg">
        </div>
    </div>
  </form>
  <div class="alert alert-warning" role="alert" id="location_status"></div>
  </div>
  </div>
  <p class="small text-right"><a href="https://farm4.staticflickr.com/3803/10012162166_cde34d427e_z_d.jpg">Image Copyright Nicolas Raymond</a></p>
<div class="row about">
  <div class="col-md-12">
    <h3>What is The Best of Local?</h3>
    <p>The Best of Local brings together cultural and entertainment information about a place into one interface. It combines information from <a href="http://en.wikipedia.org" target="_blank">Wikipedia</a>, restaurants and reviews from <a href="http://yelp.com" target="_blank">Yelp</a>, attractions with <a href="http://google.com" target="_blank">Google</a> Places, upcoming events with <a href="http://eventful.com" target="_blank">Eventful</a>, historical artifacts with the <a href="http://dp.la" target="_blank">Digital Public Library of America</a>, and recent pictures from <a href="http://flickr.com" target="_blank">Flickr</a>.</p>
    <p>It's a veritable one stop shop for getting the scoop on your city or town!</p>
  </div>
</div>
<div class="made">
  <div class="row">
    <div class="col-md-12">
    <h3>How is The Best of Local Made?</h3>
    <p>The Best of Local uses HTML5, CSS3, Javascript, JQuery, PHP, Bootstrap, Less, and several APIs. I chose to use Bootstrap framework to allow provide a responsive grid. I used Less, a CSS preprocessor, to add custom styling and compress the CSS files for Bootstrap.</p>
    <h4>APIs</h4>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-4 col-md-3">
      <div class="thumbnail">
        <img src="http://epicenter.geobytes.com/images/Geobytes-red_small.gif" alt="GeoBytes logo">
        <div class="caption">
          <h3>GeoBytes</h3>
          <p>The GeoBytes API was used for the autocomplete search box. JQuery was used get JSON from the Cities API.</p>
          <p><a href="http://www.geobytes.com/" class="btn btn-primary" role="button">GeoBytes</a> </p>
        </div>
      </div>
    </div>
     <!--<div class="col-sm-4 col-md-3">
      <div class="thumbnail">
        <img src="holder.js/300x300" alt="...">
        <div class="caption">
          <h3>WeatherUnderground</h3>
          <p>...</p>
          <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
        </div>
      </div>
    </div>-->
     <div class="col-sm-4 col-md-3">
      <div class="thumbnail">
        <img src="http://s3-media3.fl.yelpcdn.com/assets/2/www/img/2d7ab232224f/developers/yelp_logo_100x50.png" alt="Yelp Logo">
        <div class="caption">
          <h3>Yelp</h3>
          <p>The Yelp API was used to pull in restaurants and their reviews by location</p>
          <p><a href="http://www.yelp.com/developers/documentation" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
        </div>
      </div>
    </div>
     <div class="col-sm-4 col-md-3">
      <div class="thumbnail">
        <img data-src="holder.js/300x300" alt="...">
        <div class="caption">
          <h3>Google Places</h3>
          <p>...</p>
          <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-4 col-md-3">
      <div class="thumbnail">
        <img data-src="holder.js/300x300" alt="...">
        <div class="caption">
          <h3>DPLA</h3>
          <p>...</p>
          <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
        </div>
      </div>
    </div>
    <div class="col-sm-4 col-md-3">
      <div class="thumbnail">
        <img data-src="holder.js/300x300" alt="...">
        <div class="caption">
          <h3>Wikipedia</h3>
          <p>...</p>
          <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
        </div>
      </div>
    </div>
    <div class="col-sm-4 col-md-3">
      <div class="thumbnail">
        <img data-src="holder.js/300x300" alt="...">
        <div class="caption">
          <h3>GeoNames</h3>
          <p>...</p>
          <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
        </div>
      </div>
    </div>
    <div class="col-sm-4 col-md-3">
      <div class="thumbnail">
        <img data-src="holder.js/300x300" alt="...">
        <div class="caption">
          <h3>Thumbnail label</h3>
          <p>...</p>
          <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
<div class='footer'>
  <p class='center-block'>Made by <a href='http://eliwire.com'>Eli Zoller</a></p>
</div>
</div>
<script>
$(function () 
 {
   $("#city").autocomplete({
    source: function (request, response) {
     $.getJSON(
      "http://gd.geobytes.com/AutoCompleteCity?callback=?&q="+request.term,
      function (data) {
       response(data);
      }
     );
    },
    minLength: 3,
    select: function (event, ui) {
     var selectedObj = ui.item;
     $("#city").val(selectedObj.value);
     return false;
    },
    open: function () {
     $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
    },
    close: function () {
     $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
    }
   });
   $("#city").autocomplete("option", "delay", 100);
  });
</script>
<script>
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
        $("#location_status").show();
        $("#location_status").html("<p>Looking for you...<p>");
    } else {
        $("#location_status").html("<p>Geolocation is not supported by this browser.</p>");
    }
}
function showPosition(position) {
    var json = $.ajax({
      type: 'POST',
      url: 'getlocation.php',
      data: {lat: position.coords.latitude, lon: position.coords.longitude },
      success: function(response) {
        $("#city").val(response);
        $("#lat").val(position.coords.latitude);
        $("#lon").val(position.coords.longitude);
        $("#location_status").addClass('alert-success').removeClass('alert-warning');
        $("#location_status").html("<p>We found you!</p>");
        setTimeout(function() {
            $('#location_status').fadeOut('fast');
        }, 2000);
      }
      });
}
</script>
</body>
</html>