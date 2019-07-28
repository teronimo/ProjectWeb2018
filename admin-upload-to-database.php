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
		/////////////////////////////////// centroid
		$cor_d  =  explode(' ', $placemarks[$i]->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates);
		$cor_lat = array();
		$cor_long = array();
		$qtmp_lat = array();
		$qtmp_long = array();
		$qtmp = array();
		foreach($cor_d as $value){
			$qtmp[]=$value;
			$tmp = explode(',',$value);
			$qtmp_lat[] = $tmp[0];
			$qtmp_long[] = $tmp[1];
		}
		$sum_x = 0; //to a8roisma twn x 
		$sum_y = 0; //to a8roisma twn y
		 
		$arrayLength = count($qtmp_lat);
		$k = 0;
		while ($k < $arrayLength){
			$x = (float)$qtmp_lat[$k];
			$y = (float)$qtmp_long[$k];
			$sum_x = $sum_x + $x;
			$sum_y = $sum_y + $y;		
			$k = $k + 1;
		}
		$centoid_x = $sum_x / $arrayLength; // x gia to kentroides
		$centoid_y = $sum_y / $arrayLength; // y gia to kentroides
		$centroid = "$centoid_x"." , "."$centoid_y";
		///////////////////////////////////		
		
		
		$population = $placemarks[$i]->description;
		?>
		<script>
			var descValuePop = 0;
			var descValueGid = 0;
			var descType = document.getElementsByClassName("atr-name")[<?php echo $i ?>].innerHTML;
			console.log(descType);

			if (descType=="Population")
			{
				var descValuePop = document.getElementsByClassName("atr-value")[<?php echo $i ?>].innerHTML;
				console.log(descValuePop);
			}
			
			if (descType=="gid")
			{
				var descValueGid = document.getElementsByClassName("atr-value")[<?php echo $i ?>].innerHTML;
				console.log(descValueGid);
			}

		</script>

		<?php
		   $typePop = "<script>document.writeln(descType);</script>";
		   $valuePop = "<script>document.writeln(descValuePop);</script>";
		   $valueGid = "<script>document.writeln(descValueGid);</script>";
		

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
			$con->query("INSERT INTO map (name, coordinates, central, population) VALUES ('$coordinates', '$cor_p', '$centroid', '$population')");
		}
		for ($j = 0; $j < sizeof($polygons); $j++)
		{
			$population = $placemarks[$i]->description;
			?>
			<script>
				var descValuePop = 0;
				var descValueGid = 0;
				var descType = document.getElementsByClassName("atr-name")[<?php echo $i ?>].innerHTML;
				console.log(descType);

				if (descType=="Population")
				{
					var descValuePop = document.getElementsByClassName("atr-value")[<?php echo $i ?>].innerHTML;
					console.log(descValuePop);
				}
				
				if (descType=="gid")
				{
					var descValueGid = document.getElementsByClassName("atr-value")[<?php echo $i ?>].innerHTML;
					console.log(descValueGid);
				}

			</script>

			<?php
			   $typePop = "<script>document.writeln(descType);</script>";
			   $valuePop = "<script>document.writeln(descValuePop);</script>";
			   $valueGid = "<script>document.writeln(descValueGid);</script>";
			   echo $typePop, " ", $valuePop, $valueGid;
			if (isset($polygons[$j]->Polygon->outerBoundaryIs->LinearRing->coordinates))
			{
				
				$cor_d  =  explode(' ', $placemarks[$i]->MultiGeometry->Polygon->outerBoundaryIs->LinearRing->coordinates);
				$cor_lat = array();
				$cor_long = array();
				$qtmp_lat = array();
				$qtmp_long = array();
				$qtmp = array();
				foreach($cor_d as $value){
					$qtmp[]=$value;
					$tmp = explode(',',$value);
					$qtmp_lat[] = $tmp[0];
					$qtmp_long[] = $tmp[1];
				}
				$sum_x = 0; //to a8roisma twn x 
				$sum_y = 0; //to a8roisma twn y
				 
				$arrayLength = count($qtmp_lat);
				$k = 0;
				while ($k < $arrayLength){
					$x = (float)$qtmp_lat[$k];
					$y = (float)$qtmp_long[$k];
					$sum_x = $sum_x + $x;
					$sum_y = $sum_y + $y;		
					$k = $k + 1;
				}
				$centoid_x = $sum_x / $arrayLength; // x gia to kentroides
				$centoid_y = $sum_y / $arrayLength; // y gia to kentroides
				$centroid = "$centoid_x"." , "."$centoid_y";
				
				
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
			$con->query("INSERT INTO map (id, name, coordinates, central, population) VALUES ('$valueGid', '$coordinates', '$cor_p', '$centroid', '$valuePop')");
			}
		}
	    //$f_d = str_replace('"', '', str_replace(']', '', str_replace('[', '', $cor_d)));	
	}	
	mysqli_close($con);
}
?>