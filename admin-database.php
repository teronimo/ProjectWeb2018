<?php
include_once 'db_connect.php';
session_start();
header("Content-Type: text/html; charset=utf-8");

$myKml = "geonode-population_data_per_block.kml";
$xml = simplexml_load_file($myKml);

$placemarks = $xml->Document->Folder->Placemark;

$query = '';
$run = '';
$coordinates1 = '';
$cor_d1 = '';
for ($i = 0; $i < sizeof($placemarks); $i++)
{
	$coordinates = $placemarks[$i]->name;
	$cor_d = explode(' ', $placemarks[$i]->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates);
	$qtmp=array();
	foreach($cor_d as $value)
	{
		$qtmp[] = $value ; 
	}	

	$cor_d = json_encode($qtmp);
	
	$con->query("INSERT INTO map (name, coordinates) VALUES ('$coordinates', '$cor_d')");

    //$f_d = str_replace('"', '', str_replace(']', '', str_replace('[', '', $cor_d)));	
}

mysqli_close($con);?>