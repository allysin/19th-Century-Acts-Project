<?php

require_once "db.php";

$sql = $PDO->query("SELECT city, country, latitude as lat,
longitude as lon, venueName, venueid
FROM venues
WHERE 
NOT latitude = 'NULL'
AND NOT venueName = 'Unknown Theater'");



$geojson = array( 
'type' => 'FeatureCollection', 
'features' => array()
);



while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
    $marker = array(
    'type' => 'Feature',
    'properties' => array(
    'venue'=>$row['venueName'],
    'venueID'=>$row['venueid'],
      'city' => $row['city'],
      'country' => $row['country']
    ),
    'geometry' => array(
      'type' => 'Point',
      'coordinates' => array( 
        $row['lon'], 
        $row['lat']
      )
    )
  );
  array_push($geojson['features'], $marker);
}

$geo = json_encode($geojson, JSON_NUMERIC_CHECK);

?>
 

<!DOCTYPE html>
<html>
<head>
	<title>Mapping Ira Aldridge</title>
	<meta charset="utf-8" />
	<meta name="description" content="Visualizing Digital Humanities: Ira Aldridge 19th Century Actor">
<meta name="keywords" content="19th Century, 19th Century Acts, Theater, Theatre, Aldridge, Acting, Rhetorical Acting, Digital Humanities, Historical Visualizations, Henry Siddons">


	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="accordion/modernizr.acc.js"></script>
	

	
	
	<link href='http://fonts.googleapis.com/css?family=Crimson+Text' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.4.5/leaflet.css" />
	<link rel="stylesheet" type="text/css" media="(min-width:601px)" href="accordion/accordion.css">
	<link rel="stylesheet" type="text/css"  media="(max-width: 600px)" href="accordion/mobile.css" />
	<link rel="stylesheet" type="text/css"  media="(max-width: 360px)" href="accordion/mobile360.css" />
	<link href="//fonts.googleapis.com/css?family=PT+Sans:400italic,400,700italic,700" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" href="header/favicon.ico" type="image/x-icon">



	<!--[if lte IE 8]><link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.4.5/leaflet.ie.css" /><![endif]-->
  
</head>
<body>

	<div id="map" style="position:absolute; top:0; bottom:0; right:0; left:0;"></div>

<div class="hello">
<a href="index.html"><img src="header/19thCActs_logo.jpg" alt="19th Century Acts Logo"></a> 
<h1>Mapping Ira Aldridge:</h1>
<ul class="extra">
	<a href="map.php"><li>Theaters</li></a>
	  <li></li>
  <a href="world.html"><li> Around the World</li></a>
  <li></li>
  <a href="time.html"><li>Roles</li></a>
</ul>
</div>


<div class="sidebar">
<div class="shadow">
<section class="ac-container">
<div id="about">
<h2>Theaters</h2>
<p>
This map plots theaters that esteemed 19th century stage actor Ira Aldridge (July 24, 1807 - August 7, 1867) is known to have performed at. 
Although many holes exist in this tracing of his life, when possible we have included the roles and plays he took on. 
</p>
</div>
</section>
</div>
</div>

<div id="moreInfo">
<a id="close" onclick="closeIt()"><img src="accordion/close.png" ></a>
<p>
</p>
</div>


<div class="goodbye">
<img src="footer/teal_circle.png" alt="teal circle">
<table cellspacing=0>
<tr class="top">
	<td>Home</td>
	<td>About</td>
	<td>Tools</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<td class="med"><a href="index.html"> 19th Century Acts!</a></td>
	<td class="med"><a href="about.html">About 19th Century Acts!</a></td>
	<td class="med"><a href="map.php">Mapping Ira Aldridge</a></td>
	<td class="med"><a href="ISO/mediaDB.php">Sights & Sounds</a></td>
	<td class="med"><a href="resources.html">Resources</a></td>

</tr>
<tr>
	<td> &nbsp;</td>
	<td class="med"><a href="mailto:amanjo@umich.edu">Contact Us</a></td>
	<td class="med"><a href="gestures.html">Acting Styles</a></td>
</tr>
</table>
</div>


<script src="http://cdn.leafletjs.com/leaflet-0.4.5/leaflet.js"></script>

	<script type="text/javascript">
var map;

		var mapquestOSM = new L.TileLayer("http://{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png", {
			maxZoom: 13,
			opacity:.6,
			subdomains: ["otile1", "otile2", "otile3", "otile4"],
			noWrap: true,
			attribution: 'Tiles courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a>. Map data (c) <a href="http://www.openstreetmap.org/" target="_blank">OpenStreetMap</a> contributors, CC-BY-SA.'
		});

		var mapquestOAM = new L.TileLayer("http://{s}.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.jpg", {
			maxZoom: .4,
			opacity:100,
			subdomains: ["oatile1", "oatile2", "oatile3", "oatile4"],
			noWrap: true,
			attribution: 'Tiles courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a>. Map data (c) <a href="http://www.openstreetmap.org/" target="_blank">OpenStreetMap</a> contributors, CC-BY-SA.'
		});


		var mbTiles = new L.tileLayer('mbtiles_serve.php?db=worldMap.mbtiles&z={z}&x={x}&y={y}', {
		    tms: true,
		    noWrap: true,
		    reuseTiles: true,
		    maxZoom: 3
		});
		
// 	var EnglandTiles = new L.tileLayer('mbtiles_serve.php?db=England3.mbtiles&z={z}&x={x}&y={y}', {
// 		    tms: true,
// 		    opacity:0,
// 		    noWrap: true,
// 		    reuseTiles: true
// 		});

		map = new L.Map("map",{
			zoom: 2,
			center: [55.9410655,-3.2053836],
           //  center: [36.315125, -88.769531],
			layers: [mapquestOSM, mbTiles]
		});
		
		map.setView([55.66, -15], 3);
		map.setMaxBounds(map.getBounds());

		// var baseLayers = {
// 			"MapQuest Streets": mapquestOSM,
// 			"MapQuest Aerial": mapquestOAM
// 		};
		
		 var baseLayers = {
		 "19th Century World": mbTiles,
		"MapQuest Streets": mapquestOSM
		};
		
		var overlays = {
			"19th Century World": mbTiles
		};

		layersControl = new L.Control.Layers(baseLayers, overlays, {
			collapsed: true
		});

		map.addControl(layersControl);


		



var geojsonFeature =  <?php echo $geo ?>;




var clickedMarker;
 var RegularIcon = L.icon({
		iconUrl: 'markers/blue_marker.png',
		iconSize: [25, 41],
		iconAnchor: [12.5, 41],
		shadowUrl: 'http://cdn.leafletjs.com/leaflet-0.4.5/images/marker-shadow.png',
		shadowSize: [35, 51],
		shadowAnchor: [10, 51]
	});
	

	
var HighlightedIcon = L.icon({
		iconUrl: 'markers/orange_marker.png',
		iconSize: [25, 41],
		iconAnchor: [12.5, 41],
		shadowUrl: 'http://cdn.leafletjs.com/leaflet-0.4.5/images/marker-shadow.png',
		shadowSize: [35, 51],
		shadowAnchor: [10, 51]
	});


function clickFeature(e) {
    if(clickedMarker) {
          clickedMarker.setIcon(RegularIcon);
    }
    var layer = e.target;
    e.target.setIcon(HighlightedIcon);
    clickedMarker = e.target;

    map.info.update(layer.feature.properties);
}

function highlightFeature(e){

	var layer = e.target;
    e.target.setIcon(HighlightedIcon);

    map.info.update(layer.feature.properties);
}

function highlightFeature(e){

	var layer = e.target;
    e.target.setIcon(HighlightedIcon);

    map.info.update(layer.feature.properties);
}

function onEachFeature(feature, layer) {
    layer.on('click', function (e) {
    $.ajaxSetup ({
        cache: false
    });
    $.ajax({
        type: 'post',
        url: 'geoAld.php',
        dataType: "html",
        data: {
            vID: feature.properties.venueID ,
            vName: feature.properties.venue,
            vCity: feature.properties.city,
            vCountry: feature.properties.country},
    	success : function(data){ 
      			$('.ac-container').html(data);}
      		});
    	});
	layer.on({
            click: clickFeature
        });
}







markerlayer = L.geoJson(geojsonFeature, {
    onEachFeature: onEachFeature,
	pointToLayer: function (feature, latlng) {
		return L.marker(latlng, {icon: RegularIcon});
	}
}).addTo(map);



	</script>
	</script>
</body>
</html>
<head>
