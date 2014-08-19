<html>
<head>
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
</head>
<body>
<h2>The Best of Local: Discover What's Around You</h2>
  <form name="dpla_widget" method="post" action="results.php">  
  <input type="text" name="q" placeholder="Where are you?" id="city">
  <input type="hidden" name="lat" id="lat">
  <input type="hidden" name="lon" id="lon">
  <input type="submit" name="append" value="Go" >
  </form>
  <div id="demo"><button onclick="getLocation()">Get my location</button></div>
  <!--should i use wunderground instead?-->
<script>
  $("#city").autocomplete({
    source: function(request, response) {
        console.log(request.term);
        $.ajax({
            url: "http://en.wikipedia.org/w/api.php",
            dataType: "jsonp",
            data: {
                'action': "opensearch",
                'format': "json",
                'search': request.term
            },
            success: function(data) {
                response(data[1]);
            }
        });
    }
});
</script>
<script>
var x = document.getElementById("demo");
var city = document.getElementById("city");
var lon = document.getElementById("lon");
var lat = document.getElementById("lat");
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
        x.innerHTML = "Looking for you...";
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}
function showPosition(position) {
    //x.innerHTML = "Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude; 
    var json = $.ajax({
      type: 'POST',
      url: 'getlocation.php',
      data: {lat: position.coords.latitude, lon: position.coords.longitude },
      success: function(response) {
        city.value = response;
        lat.value = position.coords.latitude;
        lon.value = position.coords.longitude;
        x.innerHTML = "We found you!";
      }
      });
}
</script>
</body>
</html>