<?php
if(isset($_POST['upload']))
{
	include_once 'db_connect.php';

	$ParkNumber = $_POST['Park_Number'];
	$Center = $_POST['coordy'];
	$fileName = $_FILES['csvfile']['name'];


	$csv= file_get_contents($fileName);
	$array = array_map("str_getcsv", explode("\n", $csv));
	$ask = json_encode($array);
    $con->query("INSERT INTO simulation (Num_Par,Kamp,Center) VALUES ('$ParkNumber','$ask','$Center')");
}

header("Location: map-admin.php");
?>