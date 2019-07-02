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
		 map.setView(new L.LatLng(22.9340045, 40.6430126), 16).addLayer(osm);
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
		poly.bindPopup('<p>Πληκτρολογίστε το πλήθος των διαθέσιμων θέσων στάθμευσης, καθώς επίσης και την καμπύλη ζήτησής του τετραγώνου.</p><form id="Park_Number" method="POST" action="" enctype="multipart/form-data"><div class="form-group"><label>Number_of_parkings</label><input type="text" class="form-control" name="Park_Number" placeholder="Park_Number"><br /><label class="col-md-4 control-label">Choose CSV File</label> <input type="file" name="file" id="file" accept=".csv"></div><button type="submit" class="btn btn-primary">Submit</button></form>');

		</script>
	</body>
</html>