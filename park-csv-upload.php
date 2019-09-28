<?php
include_once 'db_connect.php';
if(isset($_POST['upload']))
{
	$ParkNumber = $_POST['Park_Number'];
	$id = $_POST['nameOfPolygon'];
	$fileName = $_FILES['csvfile']['name'];
	$ask;

	/*$csv= file_get_contents($fileName);
	$array = array_map("str_getcsv", explode("\n", $csv));
	$ask = json_encode($csv);*/
	$csvData = file_get_contents($fileName);
	$lines = explode(PHP_EOL, $csvData);
	$array = array();
	foreach ($lines as $line) {
	    $array[] = str_getcsv($line);
	}
	$ask = json_encode($array);
	print_r($array[14][1]);
    $con->query("INSERT INTO simulation (id, Num_Par, Kamp) VALUES ('$id', '$ParkNumber', '$fileName')");
}
//echo $ask;
header("Location: admin-control.php");
?>