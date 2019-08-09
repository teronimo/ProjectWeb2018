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
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Δες για άλλη ώρα την διαθεσιμότητα της πόλης! <span class="carret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li>
                            <label>Time</label>
                            <input type="time" name="time" placeholder="Select Time" id="time"/>
                            <button name="uploadtime" type="button" class="btn btn-primary" onclick="simulationGuestOnload(0)">Submit</button>
                        </li>
                    </ul>
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

                        var poly = L.polygon(polygonArray, {color :"grey", fillColor: "grey"}).addTo(map);
                        var coordSimPub = []
                        poly.bindPopup('<p>Επιλέξτε επιθυμητή ώρα και μέγιστη απόσταση από την συγκεκριμένη τοποθεσία.</p>'
                                + '<div class="form-group">'
                                + '<label>Time of simulation</label>'
                                +'<input type="time" name="timeguest" placeholder="Select Time" id="timeguest"/>'
                                +'</div>'
                                + '<div class="form-group">'
                                + '<label>Distance</label>'
                                +'<input type="number" name="distance" min="1" max="5"/>'
                                +'</div><button name="uploadtime" type="button" class="btn btn-primary" onclick="simulationGuest()" >Submit</button>');

                            poly.on('click', function(e)
                            {
                                var coord = e.latlng;
                                coordSimPub.push(coord);
                            });

                            function simulationGuest()
                            {
                                var counter;
                                var coordsim = coordSimPub[coordSimPub.length-1];

                                console.log(coordsim);
                                for (var i = 0; i < poly.getLatLngs().length; i = i + 1)
                                {
                                    if(pointInPolygon(poly.getLatLngs()[i], coordsim))
                                    {
                                        counter = i;
                                        recolor(i);
                                    }
                                }
                            }
                            
                            function recolor(l)
                            {
                                var time = document.getElementById('timeguest').value;
                                console.log(time,l);
                                var coors = polygonArray[l];
                                
                                var args = "id="+l+"&time="+time;
                                var xmlhttp = new XMLHttpRequest();

                                xmlhttp.onreadystatechange = function() 
                                {
                                    if (this.readyState == 4 && this.status == 200)
                                    {
                                        var data = this.responseText;
                                        var obj = JSON.parse(data);

                                        var color = obj[0].Color;
                                        
                                        var poly = L.polygon(coors, {color :color, fillColor: color}).addTo(map);
                                        console.log(obj);
                                    }
                                };
                                xmlhttp.open("POST", "simulation.php", true);
                                xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                                xmlhttp.send(args);

                            }

                            function pointInPolygon(polygonPath, coordinates) 
                            {
                                let numberOfVertexs = polygonPath.length - 1;
                                let inPoly = false;

                                let lastVertex = polygonPath[numberOfVertexs];
                                let vertex1, vertex2;

                                let x = coordinates.lat, y = coordinates.lng;

                                let inside = false;
                                for (var i = 0, j = polygonPath.length - 1; i < polygonPath.length; j = i++) 
                                {
                                    let xi = polygonPath[i].lat, yi = polygonPath[i].lng;
                                    let xj = polygonPath[j].lat, yj = polygonPath[j].lng;

                                    let intersect = ((yi > y) != (yj > y))
                                        && (x < (xj - xi) * (y - yi) / (yj - yi) + xi);
                                    if (intersect) inside = !inside;
                                }

                                return inside;
                            }

                            /*window.onload = function() {

                                var today = new Date();
                                var time = today.getHours();

                                simulationGuestOnload(0, time);
                            };*/

                            function simulationGuestOnload(k, timeg)
                            {
                                var k = k + 1;

                                if (timeg == null)
                                {
                                    var timeg = document.getElementById('time').value;
                                }
                                
                                var coors = polygonArray[k];
                                
                                var args = "id="+k+"&time="+timeg;
                                var xmlhttp = new XMLHttpRequest();

                                xmlhttp.onreadystatechange = function() 
                                {
                                    if (this.readyState == 4 && this.status == 200)
                                    {
                                        if (polygonArray[k] == null)
                                        {
                                            return 0;
                                        }

                                        var data = this.responseText;
                                        var obj = JSON.parse(data);

                                        var color = obj[0].Color;
                                        
                                        var poly = L.polygon(coors, {color :color, fillColor: color}).addTo(map);
                                        console.log(obj);
                                        simulationGuestOnload(k, timeg);
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