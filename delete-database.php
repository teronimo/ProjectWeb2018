<?php
	include_once 'db_connect.php';
	$con->query("DELETE FROM map");
	$con->query("ALTER TABLE map AUTO_INCREMENT = 1");
	$con->query("DELETE FROM simulation");
	$con->query("ALTER TABLE simulation AUTO_INCREMENT = 1");
	header("Location: admin-control.php");
?> 