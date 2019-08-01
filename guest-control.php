<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Project Web 2018</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>

</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li>
                    <a href="#">Εκτέλεση Εξομοίωσης</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <h1>You are logged in as guest!</h1>
                <a href="#menu-toggle" class="btn btn-secondary" id="menu-toggle">Δες τις επιλογές σου!</a>
            </div>
			<div id="map">
				<html>
					<body>
						<div id="map" style="width: 1004px; height: 800px"></div>
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
						poly.bindPopup('<p>Πληκτρολογίστε το πλήθος των διαθέσιμων θέσων στάθμευσης</p><form id="Park_Number" method="POST" action="" ><div class="form-group"><input type="text" class="form-control" name="Park_Number" placeholder="Park_Number"></div> <button type="submit" class="btn btn-primary">Submit</button></form>');
						</script>
					</body>
				</html>
			</div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="jquery/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e)
    {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>