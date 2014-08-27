<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="bootstrap/css/style.css">
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
<script src="bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="bootstrap/js/html5shiv.js"></script>
      <script src="bootstrap/js/respond.min.js"></script>
    <![endif]-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45145656-1', 'auto');
  ga('send', 'pageview');

</script>
<script>
//for ie10 mobile fix
if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
    var msViewportStyle = document.createElement("style");
    msViewportStyle.appendChild(
        document.createTextNode(
            "@-ms-viewport{width:auto!important}"
        )
    );
    document.getElementsByTagName("head")[0].
        appendChild(msViewportStyle);
}
</script>
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
    <p>The Best of Local uses HTML5, CSS3, Javascript, JQuery, PHP, Bootstrap, Less, and several APIs. I chose to use Bootstrap framework to provide a responsive grid. I used Less, a CSS preprocessor, to add custom styling and compress the CSS files for Bootstrap.</p>
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
          <p><a href="http://www.geobytes.com/" class="btn btn-primary" role="button" target="_blank">API Info</a> </p>
        </div>
      </div>
    </div>
     <div class="col-sm-4 col-md-3">
      <div class="thumbnail">
        <img src="https://s.yimg.com/pw/images/goodies/white-flickr.png" alt="flickr logo">
        <div class="caption">
          <h3>Flickr</h3>
          <p>The Flickr API was used to create a carousel of images retrieved from a search based on place name.</p>
          <p><a href="https://www.flickr.com/services/api/" class="btn btn-primary" role="button" target="_blank">API Info</a></p>
        </div>
      </div>
    </div>
     <div class="col-sm-4 col-md-3">
      <div class="thumbnail">
        <img src="http://s3-media3.fl.yelpcdn.com/assets/2/www/img/2d7ab232224f/developers/yelp_logo_100x50.png" alt="Yelp Logo">
        <div class="caption">
          <h3>Yelp</h3>
          <p>The Yelp API was used to pull in restaurants and their reviews by location.</p>
          <p><a href="http://www.yelp.com/developers/documentation" class="btn btn-primary" role="button" target="_blank">API Info</a> </p>
        </div>
      </div>
    </div>
     <div class="col-sm-4 col-md-3">
      <div class="thumbnail">
        <img src="http://upload.wikimedia.org/wikipedia/commons/a/aa/Logo_Google_2013_Official.svg" alt="google logo">
        <a href="http://commons.wikimedia.org/wiki/File:Logo_Google_2013_Official.svg#mediaviewer/File:Logo_Google_2013_Official.svg">Licensed under Public domain via Wikimedia Commons</a>
        <div class="caption">
          <h3>Google Places</h3>
          <p>Google Places API was used to retrieve attractions based on location.</p>
          <p><a href="https://developers.google.com/places/documentation/" class="btn btn-primary" role="button" target="_blank">API Info</a></p>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-4 col-md-3">
      <div class="thumbnail">
        <img src="http://dp.la/assets/dpla-logo-7540ba3f90785a519efc8e58386b36d7.png" alt="dpla logo">
        <div class="caption">
          <h3>DPLA</h3>
          <p>The Digital Public Library of America API was used to bring in historical artifacts about the location.</p>
          <p><a href="http://dp.la/info/developers/codex/" class="btn btn-primary" role="button" target="_blank">API Info</a></p>
        </div>
      </div>
    </div>
    <div class="col-sm-4 col-md-3">
      <div class="thumbnail">
        <img src="http://upload.wikimedia.org/wikipedia/en/thumb/8/80/Wikipedia-logo-v2.svg/1200px-Wikipedia-logo-v2.svg.png" alt="wikipedia logo">
        <a href="http://en.wikipedia.org/wiki/File:Wikipedia-logo-v2.svg#mediaviewer/File:Wikipedia-logo-v2.svg"> Via <a href="//en.wikipedia.org/wiki/">Wikipedia</a>
        <div class="caption">
          <h3>Wikipedia</h3>
          <p>Wikipedia API was used to gather information about the place.</p>
          <p><a href="http://www.mediawiki.org/wiki/API:Main_page" class="btn btn-primary" role="button" target="_blank">API Info</a></p>
        </div>
      </div>
    </div>
    <div class="col-sm-4 col-md-3">
      <div class="thumbnail">
        <img src="images/geonames.png" alt="geonames logo">
        <div class="caption">
          <h3>GeoNames</h3>
          <p>GeoNames was used to gather required data about the specified location such as latitude and longitude coordinates, ie. geocoding and reverse geocoding.</p>
          <p><a href="http://www.geonames.org/export/web-services.html" class="btn btn-primary" role="button" target="_blank">API Info</a></p>
        </div>
      </div>
    </div>
    <div class="col-sm-4 col-md-3">
      <div class="thumbnail">
        <div class="eventful-badge eventful-medium">
          <img src="http://api.eventful.com/images/powered/eventful_88x31.gif"
            alt="Local Events, Concerts, Tickets">
          <p><a href="http://eventful.com/">Events</a> by Eventful</p>
        </div>
        <div class="caption">
          <h3>Eventful</h3>
          <p>Eventful API brings in upcoming events in the location.</p>
          <p><a href="http://api.eventful.com/" class="btn btn-primary" role="button" target="_blank">API Info</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
<hr/>
<div class="row">
  <div class="col-sm-6">
    <h3>About Me</h3>
    <p>My name is Eli Zoller. I'm a graduate of <a href="http://simmons.edu" target="_blank">Simmons College</a> with a Masters in Library and Information Science. I currently work as Systems Librarian Fellow for Web and Digital Initiatives at the <a href="http://uta.edu" target="_blank">University of Texas at Arlington</a>. My main responsibility at the <a href="http://uta.edu/library" target="_blank">UT Arlington Libraries</a> is maintain and improve the existing libraries' websites and build additional sites as needed.</p>
    <a href="http://www.eliwire.com" target="_blank" class="btn btn-primary" role="button">Personal Website</a>
    <a href="http://github.com/elizoller" target="_blank" class="btn btn-success" role="button">Github</a>
    <a href="http://www.eliwire.com/Resume_Zoller_Library.pdf" target="_blank" class="btn btn-info" role="button">Resume</a>
  </div>
  <div class="col-sm-6">
    <h3><a href="https://github.com/elizoller/neu" target="_blank" >View the Source</a></h3>
    <a href="https://github.com/elizoller/neu" target="_blank" ><img src="images/code.png" class="source"></a>
  </div>
</div>
<hr/>
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
      "http://gd.geobytes.com/AutoCompleteCity?callback=?&filter=US&q="+request.term,
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