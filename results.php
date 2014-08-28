
<?php 
if (isset($_POST['submit'])) {
  if ($_POST['q'] != NULL) {
    $cquery = $_POST['q'];
    $cquery = str_replace(' ', '+', $cquery);
    $cquery = str_replace('?', '%26', $cquery);
    $cquery = str_replace('&', '%3F', $cquery);
    $lat = $_POST['lat'];
    $lon = $_POST['lon'];
    //if lat/lon not set by submission of form/browser finding location  
    if ($lat == NULL || $lon == NULL){
         //using geonames to get lat, long if not provided from form submit
      $locationfile = file_get_contents("http://api.geonames.org/postalCodeSearchJSON?placename=" . $cquery . "&maxRows=1&username=elizoller");
      $locationfile = json_decode($locationfile);
      foreach($locationfile->postalCodes as $place){
        $lat = $place->lat;
        $lon = $place->lng;
      }
    }
    //testing if no location found then we can't find the place
    if (isset($locationfile->status)) {
      $error_message = "We're sorry but we can't seem to find that city. Try <a href='http://eliwire.com/neu'>a different city</a>. The Best of Local works best with United States locations due to its dependency on external APIs. Thanks!";
    }
    else {
      //using geonames to get official country, city, and state from lat/lon
      foreach($locationfile->postalCodes as $place){
        $city = $place->placeName;
        $country = $place->countryCode;
        $state = $place->adminCode1;
        $state_full = $place->adminName1;
      }
      $imgurl = "http://staticmap.openstreetmap.de/staticmap.php?center=" . $lat . "," . $lon . "&zoom=14&size=1200x300&maptype=mapnik";
    }
  } else {
    $error_message = "We didn't get your location. <a href='http://eliwire.com/neu'>Enter your city</a> or use the <a href='http://eliwire.com/neu'><span class='glyphicon glyphicon-map-marker'></span></a> to find your location.";
  } 
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf8">
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
<style>
#map {
  background: url('<?php echo $imgurl; ?>');
}
</style>
</head>
<body>
<div class="container-fluid">
<div class="row">
  <h2><a href="index.php">The Best of Local: Discover What's Around You</a></h2>
</div>
<?php
if (isset($error_message)) {
  echo "<div class='row'><p>" . $error_message . "</p></div>";
}
else {
?>
<div class="row">
  <div class="col-xs-12" id="map">
    <h1 class="text-center"><?php echo $city . ", " . $state; ?></h1>
  </div>
  <a href='http://www.openstreetmap.org/search?query=<?php echo urlencode($lat .  ", " . $lon); ?>' target='_blank'>View Map</a>
</div>
<div class="content">

</div>
<?php
  } //end else no error message
} //end else no submit or query is null
?>
<hr/>
  <div class='footer'>
    <p class='center-block'>Made by <a href='http://eliwire.com'>Eli Zoller</a></p>
  </div>
</div>
  <script>
     $(document).ready(function() {
        $.ajax({
          url: 'api.php',
          type: 'POST',
          data: {action: 'all', lat: '<?php echo $lat;?>', lon: '<?php echo $lon;?>', city: '<?php echo $city;?>', cquery: '<?php echo $cquery;?>', state: '<?php echo $state;?>', state_full: '<?php echo $state_full;?>'},
          beforeSend: function() {
            $(".content").html("<h3>Loading information...</h3>");
          },
          success: function(data) {
            $(".content").html(data);
          }
        });
        $("#flickr_carousel").carousel();
      });
  </script>
  </body>
  </html>