<!DOCTYPE html>
<html>
	<head>
		 <title>Leaflet Map Viewer
		</title>
		 <meta charset="utf-8" />
		 <link rel="stylesheet" href="leaflet/leaflet.css" />
		 <!--[if lte IE 8]><link rel="stylesheet" href="leaflet/leaflet.ie.css" /><![endif]-->
		 <script src="leaflet/leaflet.js"></script>
	</head>
	<body>
		 <div id="map" style="width: 1004px; height: 590px"></div>
		 <script type="text/javascript">
		 var map = new L.Map('map');
		 var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
		 osmAttrib = 'Map data &copy; 2011 OpenStreetMap contributors',
		 osm = new L.TileLayer(osmUrl, {maxZoom: 18, attribution: osmAttrib});
		 map.setView(new L.LatLng(38.2462420, 21.7350847), 16).addLayer(osm);
		 var popup = new L.Popup();
		 </script>
	</body>
</html>