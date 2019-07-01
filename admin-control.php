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

</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li>
                    <a href="admin-database-options.php">Διαχείριση Βάσης Δεδομένων</a>
                </li>
                <li>
                    <a href="#">Διαχείρηση Βάσης Δεδομένων</a>
					<ul id="submenu">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Διαχείρηση Βάσης Δεδομένων <span class="carret"></span> </a>                 
					<ul class="dropdown-menu dropdown-menu-right">
						<li>
							<a href="admin-file-upload.php">Φόρτωση Αρχείου kml</a>
						</li>
						<li>
							<a href="#">Διαγραφή Βάσης</a>
							<?php
								include_once 'db_connect.php';
								$con->query("DELETE FROM map");
								$con->query("ALTER TABLE map AUTO_INCREMENT = 1");
								$con->query("DELETE FROM map")
							?> 
						</li>
					</ul>
				</li>
				<li> 
                    <a href="#">Απεικόνιση Στοιχείων Πόλης</a>
                </li>
                <li>
                    <a href="#">Διαχείριση Οικοδομικών Τετραγώνων</a>
                </li>
                <li>
                    <a href="#">Εκτέλεση Εξομοίωσης</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <h1>Welcome Back Admin</h1>
                <a href="#menu-toggle" class="btn btn-secondary" id="menu-toggle">Toggle Menu</a>
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
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html