<!DOCTYPE html>
<html>
	<head>
		 <title>Leaflet Map Viewer
		 </title>
		 <meta charset="utf-8" />
		 <link rel="stylesheet" href="leaflet/leaflet.css" />
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

		<?php
			include'db_connect.php';

			if($coordinates = $con->query("SELECT coordinates FROM map"))
				{
					?>
					var polygonArray = [];
					<?php 
					while ($row = $coordinates->fetch_object())
				    {
				    	?>
				    	polygonArray.push([<?php echo $row->coordinates ?>]);
				    	<?php
				    }				
				} 
		?>

		console.log(polygonArray);
		var poly = L.polygon(polygonArray, {color :"grey", fillColor: "grey"}).addTo(map);
		poly.bindPopup('<p>Πληκτρολογίστε το πλήθος των διαθέσιμων θέσων στάθμευσης</p><form id="Park_Number" method="POST" action="" ><div class="form-group"><input type="text" class="form-control" name="Park_Number" placeholder="Park_Number"></div> <button type="submit" class="btn btn-primary">Submit</button></form>');
		</script>
	</body>
</html>