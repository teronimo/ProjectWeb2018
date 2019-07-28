<?php
	function simulation($time,$center)
	{
		include_once 'db_connect.php';

		$NumPark = $con->query("SELECT Num_Par FROM simulation WHERE Center = '$center'");
		$Population = $con->query("SELECT population FROM map WHERE");
		$Centroid = $con->query("SELECT central FROM map WHERE");
		$Kamp = $con->query("SELECT Kamp FROM simulation WHERE Center = '$center'");
		$PolygonId =
		$NeighPark = $Population * 0.2;
		$FreePark = $NumPark - $NeighPark; 

		if ($NeighPark >= $NumPark)
		{
			$FreePark = 0;
			$NeighPark = $NumPark;
		}

		$PercNeighPark = $NeighPark/$NumPark;

		if ($PercNeighPark <= 0.59)
		{
			$Color = "Green";
		}
		elseif ($PercNeighPark <= 0.84) 
		{
			$Color = "Yellow";
		}
		else
		{
			$Color = "Red";
		}

		$TmpResult=array($PolygonId,$Centroid,$PercNeighPark); 
		$Result = json_encode($TmpResult);

		return $Result;
	}

?>