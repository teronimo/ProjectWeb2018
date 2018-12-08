<?php
include_once 'db_connect.php';
session_start();
header("Content-Type: text/html; charset=utf-8");

$myKml = "geonode-population_data_per_block.kml";
$xml = simplexml_load_file($myKml);

$placemarks = $xml->Document->Folder->Placemark;
$con=mysqli_connect("localhost","root", "", "project_2018");

$query = '';
$run = '';
for ($i = 0; $i < sizeof($placemarks); $i++)
{
	$coordinates = $placemarks[$i]->name;
	$cor_d = explode(' ', $placemarks[$i]->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates);
	$qtmp=array();
	foreach($cor_d as $value)
	{
		//$tmp = explode(',',$value);
		$qtmp[] = $value ; 
	}	

	$cor_d = json_encode($qtmp);

	//$query .='\''.$coordinates.'\', \''.$cor_d.'\'';
	//$run .="INSERT INTO map (name, coordinates) VALUES ($coordinates, $cor_d);";
	if ($run = $con->prepare("INSERT INTO map (name, coordinates) VALUES (?, ?)"))
	{
		$run->bind_param($coordinates, $f_d);
		$run->execute();
	}
}
//echo $run;
//mysqli_query($con,$run);
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<body>


<?php
echo "<h1>PHP is Fun!</h1>";
echo "Hello world!<br>";
echo "I'm about to learn PHP!<br>";
echo "This ", "string ", "was ", "made ", "with multiple parameters.";
?> 

</body>
</html>