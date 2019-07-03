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

		poly.bindPopup('<p>Πληκτρολογίστε το πλήθος των διαθέσιμων θέσων στάθμευσης, καθώς επίσης και την καμπύλη ζήτησής του τετραγώνου.</p>'
						+ '<form id="Park_Number" method="POST" action="park-csv-upload.php" enctype="multipart/form-data">'
							+ '<div class="form-group">'
									+ '<label>Polygon Name</label>'
									+ '<input type="text" name="coordy" placeholder="Auto Complete" id="coordy"/>'
									+ '<label>Number_of_parkings</label>'
									+	'<input type="number" name="Park_Number" placeholder="Park_Number">' 
									+	'<br />' 
									+ '<label>Choose CSV File</label>'
									+	'<input type="file" name="csvfile" id="csvfile" accept=".csv">'
								+ '</div> <button name="upload" type="submit" class="btn btn-primary">Submit</button>'
						+ '</form>');

		poly.on('click', function(e){
		  var coord = e.latlng;
		  var lat = coord.lat;
		  var lng = coord.lng;		  
		  document.getElementById('coordy').value = poly.getBounds().getCenter() ;
		});
		</script>
	</body>
</html>