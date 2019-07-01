<?php
function upload($name)
{
include_once 'db_connect.php';
session_start();
header("Content-Type: text/html; charset=utf-8");

$myKml = $name;
$xml = simplexml_load_file($myKml);

$placemarks = $xml->Document->Folder->Placemark;
$polygons = $xml->Document->Folder->Placemark->MultiGeometry->MultiGeometry;
for ($i = 0; $i < sizeof($placemarks); $i++)
{
	$coordinates = $placemarks[$i]->name;
	if (isset($placemarks[$i]->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates))
	{
		$cor_p = '';
		$l=0; //vlepo se poia x,y vriskomai gia na ta xorisw me komma
		$cor_d = explode(' ', $placemarks[$i]->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates);
		foreach($cor_d as $value)
		{
			
			$tmp = explode(',',$value);
			if ($l==0)
			{
				$cor_p.= '['.$tmp[0].','.$tmp[1].']'.',';
				$l=$l+1;
			}
			else if($l==1)
			{
				$cor_p.='['.$tmp[0].','.$tmp[1].']';
				$l=$l+1;
			}
			else if ($l>1)
			{
				$cor_p.= ','.'['.$tmp[0].','.$tmp[1].']';
			}	
		}
		$con->query("INSERT INTO map (name, coordinates) VALUES ('$coordinates', '$cor_p')");
	}
	for ($j = 0; $j < sizeof($polygons); $j++)
	{
		if (isset($polygons[$j]->Polygon->outerBoundaryIs->LinearRing->coordinates))
		{
			$cor_p = '';
			$l=0; //vlepo se poia x,y vriskomai gia na ta xorisw me komma
			$cor_d = explode(' ', $polygons[$j]->Polygon->outerBoundaryIs->LinearRing->coordinates);
			foreach($cor_d as $value)
			{
				$tmp = explode(',',$value);
				if ($l==0)
				{
					$cor_p.= '['.$tmp[0].','.$tmp[1].']'.',';
					$l=$l+1;
				}
				else if($l==1)
				{
					$cor_p.='['.$tmp[0].','.$tmp[1].']';
					$l=$l+1;
				}
				else if ($l>1)
				{
					$cor_p.= ','.'['.$tmp[0].','.$tmp[1].']';
				}	
			}
			$con->query("INSERT INTO map (name, coordinates) VALUES ('$coordinates', '$cor_p')");
		}
	}
    //$f_d = str_replace('"', '', str_replace(']', '', str_replace('[', '', $cor_d)));	
}

mysqli_close($con);
}
?>