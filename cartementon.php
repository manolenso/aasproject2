<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-responsive.min.css">
<link rel="stylesheet" href="css/main.css">
<title>Google Maps : &lt;default&gt;</title>
<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=true'></script>

  <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

</head>

<body>
          <div class="container">
            <div class="row-fluid">
              <div class="span8">
  <p>
  <a class="btn btn-large btn-primary" href="index.php"><i class="icon-home icon-white"></i> Accueil   </a>
</p>
<div id="mapCanvas" style="width:100%; height:100%; min-width:300px; min-height:300px"></div>
<script type="text/javascript">
// initialize the google Maps

     function initializeGoogleMap() {
    // set latitude and longitude to center the map around
    var latlng = new google.maps.LatLng(43.768430,7.484306);

    // set up the default options
    var myOptions = {
      zoom: 17,
      center: latlng,
      navigationControl: true,
      navigationControlOptions:
        {style: google.maps.NavigationControlStyle.DEFAULT,
       position: google.maps.ControlPosition.TOP_LEFT },
      mapTypeControl: true,
      mapTypeControlOptions:
        {style: google.maps.MapTypeControlStyle.DEFAULT,
       position: google.maps.ControlPosition.TOP_RIGHT },

      scaleControl: true,
       scaleControlOptions: {
            position: google.maps.ControlPosition.BOTTOM_LEFT
        },
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      draggable: true,
      disableDoubleClickZoom: false,
      keyboardShortcuts: true
    };
    var map = new google.maps.Map(document.getElementById("mapCanvas"), myOptions);
    if (false) {
      var trafficLayer = new google.maps.TrafficLayer();
      trafficLayer.setMap(map);
    }
    if (false) {
      var bikeLayer = new google.maps.BicyclingLayer();
      bikeLayer.setMap(map);
    }
    if (true) {
      addMarker(map,43.768430,7.484306,"We are here");
    }
    }

    window.onload = initializeGoogleMap();

   // Add a marker to the map at specified latitude and longitude with tooltip
   function addMarker(map,lat,long,titleText) {
      var markerLatlng = new google.maps.LatLng(lat,long);
    var marker = new google.maps.Marker({
          position: markerLatlng,
          map: map,
          title:"Le parking est ici !",
      icon: ""});
   }
</script>
            <section class="row-fluid">
              <div class="span4 visible-desktop">Target Desktop.</div>
              <div class="span4 visible-tablet">Target Tablet.</div>
              <div class="span4 visible-phone">Target Phone.</div>
            </section>

            <footer>
                <p>&copy; AAS Sirlo 2013</p>
            </footer>

      </div> <!-- /container -->
    </div><!-- ./class span8 -->
 </div><!-- ./classe row -->
</body>
</html>
