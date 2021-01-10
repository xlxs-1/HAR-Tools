<?php session_start();
include ($_SERVER["DOCUMENT_ROOT"].'/../utils.php');
if (isset($_SESSION["email"])) {
  //todo
}
?>





<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.css"/>
  <link rel="stylesheet" type="text/css" href="/css/style.css"/>
  <link rel="stylesheet" type="text/css" href="/css/sign.css"/>
  <link rel="stylesheet" href="/leaflet/leaflet.css"/>
  <!--<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>-->
   <!--<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>-->
  <script src="/js/bootstrap.bundle.js"></script>
  <script src="/jquery-3.5.1.js"></script>
  <script src="/leaflet/leaflet.js"></script>
  <script src="/leaflet/heatmap.js"></script>
  <script src="/leaflet/leaflet-heatmap.js"></script>

  <?php if (!isset($_SESSION["email"])):?>
    <script>
    function fn(){location.replace("/login");}
      setTimeout(fn,750);
    </script>
  <?php endif?>
  <title>Data visualization</title>
</head>
<body>
<?php if (isset($_SESSION["email"])):?>
  <?php echo"Welcome ".(isset($_SESSION["email"])?htmlspecialchars($_SESSION["email"]):"guest").".";?>
  <?php include ($_SERVER["DOCUMENT_ROOT"]."/../menu.php");?>
  <div id="mapid" class="" style="height: 900px;"></div>
  <!--<div id="mapid2" class="" style="height: 900px;"></div>-->
  <script>//https://www.youtube.com/watch?v=nZaZ2dB6pow
    var mapLayer=L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution:'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'})


    var cfg = {//  https://www.patrick-wied.at/static/heatmapjs/example-heatmap-leaflet.html
      // radius should be small ONLY if scaleRadius is true (or small radius is intended)
      // if scaleRadius is false it will be the constant radius used in pixels
      "radius": 3,
      "maxOpacity": .8,
      // scales the radius based on map zoom
      "scaleRadius": true,
      // if set to false the heatmap uses the global maximum for colorization
      // if activated: uses the data maximum within the current map boundaries
      //   (there will always be a red spot with useLocalExtremas true)
      "useLocalExtrema": false,
      // which field name in your data represents the latitude - default "lat"
      latField: 'y',
      // which field name in your data represents the longitude - default "lng"
      lngField: 'x',
      // which field name in your data represents the data value - default "value"
      valueField: 'count'
    };
    var heatmapLayer = new HeatmapOverlay(cfg);


    var map = L.map('mapid', {
      center: [39.73, -104.99],
      zoom: 7,
      layers: [mapLayer,heatmapLayer]
    });

    //map.on('moveend', function() { //may improve later
      //let b=map.getBounds();
      //var xy={"xMin":b._southWest.lng,"yMin":b._southWest.lat,"xMax":b._northEast.lng,"yMax":b._northEast.lat};
      $.ajax({/*data:xy,*/cache:false,method:"POST", url: "/geoQueriesAPI.php", success: function(result){
        
        console.log(result);
        let arr=JSON.parse("["+result+"]");
        var testData = {
          max: 10,
          data: arr
        };
        console.log(arr);
        heatmapLayer.setData(testData);
      }});
        
        
        
    //});
    // todo
  </script>
<?php else:?>
Log in first.
<?php endif?>
  <footer class="bd-footer bg-dark text-light fixed-bottom text-center">
    <div class="container">
      <p class="mb-0">Designed for WEB by Spiros, Basilis and Aris</p>
    </div>
  </footer>
</body>
</html>

