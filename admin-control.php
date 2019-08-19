<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
    <title>Project Web 2018</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/simple-sidebar.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Διαχείρηση Βάσης Δεδομένων <span class="carret"></span> </a>                 
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li>
                            <a href="admin-file-upload.php">Φόρτωση Αρχείου kml</a>
                        </li>
                        <li>
                            <a href="delete-database.php" onclick="return confirm('Θέλετε να γίνει διαγραφή της Βάσης Δεδομένων;')">Διαγραφή Βάσης</a>
                        </li>
                    </ul>
                </li>
                
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Εκτέλεση Εξομοίωσης <span class="carret"></span>
                     </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li>
                            <label>Time</label>
                            <input type="time" name="time" placeholder="Select Time" id="time"/>
                            <button name="uploadtime" type="button" class="btn btn-primary" onclick="simulation(0)">Submit</button>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <h1>Welcome Back Admin</h1>
                <a href="#menu-toggle" class="btn btn-secondary" id="menu-toggle">Δες τις επιλογές σου!</a>
            </div>
            <div id="map">
                <html>
                    <body>
                     <div id="map" style="width: 1004px; height: 900px"></div>
         <script type="text/javascript"> 
         var map = new L.Map('map');
         var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
         osmAttrib = 'Map data &copy; 2011 OpenStreetMap contributors',
         osm = new L.TileLayer(osmUrl, {maxZoom: 18, attribution: osmAttrib});
         map.setView(new L.LatLng(40.6430126,22.9340045 ), 16).addLayer(osm);
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

        var poly = L.polygon(polygonArray, {color :"grey", fillColor: "grey"}).addTo(map);

        poly.bindPopup('<p>Πληκτρολογίστε το πλήθος των διαθέσιμων θέσων στάθμευσης, καθώς επίσης και την καμπύλη ζήτησής του τετραγώνου.</p>'
                        + '<form id="Park_Number" method="POST" action="park-csv-upload.php" enctype="multipart/form-data">'
                            + '<div class="form-group">'
                                    + '<label>Polygon Name</label>'
                                    + '<input type="text" name="coordy" placeholder="Auto Complete" id="coordy"/>'
                                    + '<label>Number_of_parkings</label>'
                                    +   '<input type="number" name="Park_Number" placeholder="Park_Number">' 
                                    +   '<br />' 
                                    + '<label>Choose CSV File</label>'
                                    +   '<input type="file" name="csvfile" id="csvfile" accept=".csv">'
                                + '</div> <button name="upload" type="submit" class="btn btn-primary">Submit</button>'
                        + '</form>'
                        );

        poly.on('click', function(e){
          var coord = e.latlng;
          var lat = coord.lat;
          var lng = coord.lng;        
          document.getElementById('coordy').value = poly.getBounds().getCenter();
        });

        function simulation(k)
        {
            var k = k + 1;
            var time = document.getElementById('time').value;
            var coors = polygonArray[k];
            
            var args = "id="+k+"&time="+time;
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function() 
            {
                if (this.readyState == 4 && this.status == 200)
                {
                    if (polygonArray[k] == null)
                    {
                        return 0;
                    }
                    var color = this.responseText;
                    console.log(color);
                    var poly = L.polygon(coors, {color :color, fillColor: color}).addTo(map);

                    simulation(k);
                }
            };
            xmlhttp.open("POST", "simulation.php", true);
            xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xmlhttp.send(args);
        }
        </script>
                    </body>
                </html>
            </div>
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