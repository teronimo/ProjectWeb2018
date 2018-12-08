<?php
include_once 'db_connect.php';
session_start();
header("Content-Type: text/html; charset=utf-8");


$my_kml = "geonode-population_data_per_block.kml";
$xml = simplexml_load_file($my_kml);

$con=mysqli_connect("localhost","root", "", "project_2018");

$placemarks = $xml->Document->Folder->Placemark;

/*$con=mysqli_connect("localhost","root","","j3");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
*/

 $query = '';
 $run='';
for ($i = 0; $i < sizeof($placemarks); $i++) {
    $coordinates = $placemarks[$i]->name;
     $cor_d  =  explode(' ', $placemarks[$i]->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates);
	 $cor_lat = array();
	 $cor_long = array();
	 $qtmp_lat = array();
	 $qtmp_long = array();
     $qtmp = array();
     foreach($cor_d as $value){
          $qtmp[]=$value;
		  //$tiexei = $tmp[0].','.$tmp[1];
		  //$latitudes = $tmp[0];  //x
		  //$longitudes = $tmp[1]; //y
		  //$qtmp_lat[]=$latitudes;
		  //$qtmp_long[]=$longitudes;
		  /*echo $latitudes;
		  echo " ";
		  echo $longitudes;
		  echo " "; */
     }
	 
	$cor_d = json_encode($qtmp);
	$f_d = str_replace('"', '', str_replace(']', '', str_replace('[', '', $cor_d)));
	//echo $f_d;
	
	//$cor_lat = json_encode($qtmp_lat);
	//$f_lat = str_replace('"', '', str_replace(']', '', str_replace('[', '', $cor_lat)));
	//echo $f_lat;
	
	//$cor_long = json_encode($qtmp_long);
	//$f_long = str_replace('"', '', str_replace(']', '', str_replace('[', '', $cor_long)));
	//echo $f_long;
	
	
    //$query .='\''.$coordinates.'\', \''.$cor_d.'\'';
    //$run .="INSERT INTO map ('id', 'longitudes', 'latitudes', 'population', 'central', 'name') VALUES (NULL, '$f_lat', '$f_long', NULL, NULL, '$coordinates');";
    if ($run = $con->prepare("INSERT INTO map (name, coordinates) VALUES (?, ?)"))
	{
		echo "malaka";
		$run->bind_param($coordinates, $cor_d);
		$run->execute();
	}
	//echo $run;
    //break;
}
mysqli_real_query($con,$run);
//echo $run;

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