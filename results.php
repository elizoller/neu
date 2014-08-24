
<?php 
if (isset($_POST['submit']) && $_POST['q'] != NULL) {
    $cquery = $_POST['q'];
    $cquery = str_replace(' ', '+', $cquery);
    $cquery = str_replace('?', '%26', $cquery);
    $cquery = str_replace('&', '%3F', $cquery);
    $lat = $_POST['lat'];
    $lon = $_POST['lon'];
    //using geonames to get official country, city, and state
    $locationfile = file_get_contents("http://api.geonames.org/postalCodeSearchJSON?placename=" . $cquery . "&maxRows=1&username=elizoller");
    $locationfile = json_decode($locationfile);
    foreach($locationfile->postalCodes as $place){
      $country = $place->countryCode;
      $city = $place->placeName;
      $state = $place->adminCode1;
      $state_full = $place->adminName1;
    }
  if ($lat == NULL || $lon == NULL){
       //using geonames to get lat, long if not provided from form submit
    $locationfile = file_get_contents("http://api.geonames.org/postalCodeSearchJSON?placename=" . $cquery . "&maxRows=1&username=elizoller");
    $locationfile = json_decode($locationfile);
    foreach($locationfile->postalCodes as $place){
      $lat = $place->lat;
      $lon = $place->lng;
    }
  }
    $imgurl = "http://staticmap.openstreetmap.de/staticmap.php?center=" . $lat . "," . $lon . "&zoom=14&size=865x512&maptype=mapnik";
  ?>
<!DOCTYPE html>
<html>
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
<div class="row">
  <div class="col-xs-12" id="map">
    <h1 class="text-center"><?php echo $city . ", " . $state; ?></h1>
  </div>
  <a href='http://www.openstreetmap.org/search?query=<?php echo urlencode($lat .  ", " . $lon); ?>' target='_blank'>View Map</a>
</div>
<div class="content">

</div>
<?php
  }
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
          data: {action: 'all', lat: '<?php echo $lat;?>', lon: '<?php echo $lon;?>', countrycode3: '<?php echo $countrycode3; ?>', city: '<?php echo $city;?>', cquery: '<?php echo $cquery;?>', state: '<?php echo $state;?>', state_full: '<?php echo $state_full;?>'},
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