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
			
			$cx = 1;
		    $cy = 0;

		    for ($ri=0, $rl=sizeof($placemarks[$i]->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates); $ri<$rl; $ri++) 
		    {
		        $ring = $placemarks[$i]->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates[$ri];

		        for ($vi=0, $vl=sizeof($ring); $vi<$vl; $vi++) 
		        {
		            $thisx = $ring[ $vi ][0];
		            $thisy = $ring[ $vi ][1];
		            $nextx = $ring[ ($vi+1) % $vl ][0];
		            $nexty = $ring[ ($vi+1) % $vl ][1];

		            $p = ($thisx * $nexty) - ($thisy * $nextx);
		            $cx += ($thisx + $nextx) * $p;
		            $cy += ($thisy + $nexty) * $p;
		        }
		    }
		    $centroid = $cx.','.$cy;
			//$centroid = getCentroidOfPolygon($placemarks[$i]->MultiGeometry->Polygon->outerBoundaryIs, $name);
			$con->query("INSERT INTO map (name, coordinates, central) VALUES ('$coordinates', '$cor_p', '$centroid')");
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

				$cx = 0;
			    $cy = 0;

			    for ($ri=0, $rl=sizeof($polygons[$j]->Polygon->outerBoundaryIs->LinearRing->coordinates); $ri<$rl; $ri++) 
			    {
			        $ring = $polygons[$j]->Polygon->outerBoundaryIs->LinearRing->coordinates[$ri];

			        for ($vi=0, $vl=sizeof($ring); $vi<$vl; $vi++) 
			        {
			            $thisx = $ring[ $vi ][0];
			            $thisy = $ring[ $vi ][1];
			            $nextx = $ring[ ($vi+1) % $vl ][0];
			            $nexty = $ring[ ($vi+1) % $vl ][1];

			            $p = ($thisx * $nexty) - ($thisy * $nextx);
			            $cx += ($thisx + $nextx) * $p;
			            $cy += ($thisy + $nexty) * $p;
			        }
			    }
			    $centroid = $cx.','.$cy;
				$con->query("INSERT INTO map (name, coordinates, central) VALUES ('$coordinates', '$cor_p', '$centroid')");
			}
		}
	    //$f_d = str_replace('"', '', str_replace(']', '', str_replace('[', '', $cor_d)));	
	}	
	mysqli_close($con);
}

function getCentroidOfPolygon($geometry, $name) {
	    $cx = 0;
	    $cy = 0;
	    $myKml = $name;
		$xml = simplexml_load_file($myKml);

	    for ($ri=0, $rl=sizeof($geometry->LinearRing); $ri<$rl; $ri++) 
	    {
	        $ring = $geometry->LinearRing[$ri];

	        for ($vi=0, $vl=sizeof($ring); $vi<$vl; $vi++) 
	        {
	            $thisx = $ring[ $vi ][0];
	            $thisy = $ring[ $vi ][1];
	            $nextx = $ring[ ($vi+1) % $vl ][0];
	            $nexty = $ring[ ($vi+1) % $vl ][1];

	            $p = ($thisx * $nexty) - ($thisy * $nextx);
	            $cx += ($thisx + $nextx) * $p;
	            $cy += ($thisy + $nexty) * $p;
	        }
	    }

	    // last step of centroid: divide by 6*A
	    $area = $this->getAreaOfPolygon($geometry);
	    $cx = -$cx / ( 6 * $area);
	    $cy = -$cy / ( 6 * $area);

	    // done!
	    return array($cx,$cy);
	}

	function getAreaOfPolygon($geometry, $name) {
	    $area = 0;
	     $myKml = $name;
		$xml = simplexml_load_file($myKml);

	    for ($ri=0, $rl=sizeof($geometry->LinearRings); $ri<$rl; $ri++) 
	    {
	        $ring = $geometry->LinearRings[$ri];

	        for ($vi=0, $vl=sizeof($ring); $vi<$vl; $vi++)
	        {
	            $thisx = $ring[ $vi ][0];
	            $thisy = $ring[ $vi ][1];
	            $nextx = $ring[ ($vi+1) % $vl ][0];
	            $nexty = $ring[ ($vi+1) % $vl ][1];
	            $area += ($thisx * $nexty) - ($thisy * $nextx);
	        }
	    }

	    // done with the rings: "sign" the area and return it
	    $area = abs(($area / 2));
	    return $area;
	}
?>