<?php

		include_once 'db_connect.php';

		$time=$_POST['time'];
		$id=$_POST['id'];
		$tmpPopulation = $con->query("SELECT population FROM map WHERE id = '$id'");
		$tmpCentroid = $con->query("SELECT central FROM map WHERE id = '$id'");
		$tmpNumPark = $con->query("SELECT Num_Par FROM simulation WHERE id = '$id'") or die($con->error);
		$tmpKamp = $con->query("SELECT Kamp FROM simulation WHERE id = '$id'") or die($con->error);


		$Population;
		$Centroid;
		$arrNumPark;
		$csvName;
		$arrCsvName;

		 while($row1 = $tmpPopulation->fetch_assoc()) 
		 {
		 	$Population=$row1['population'];
		 }

		 while($row2 = $tmpCentroid->fetch_assoc()) 
		 {
		 	$Centroid=$row2['central'];
		 }

		 while($row3 = $tmpNumPark->fetch_assoc()) 
		 {
		 	$arrNumPark=$row3['Num_Par'];
		 }

		 while($row4 = $tmpKamp->fetch_assoc()) 
		 {
		 	$arrCsvName=$row4['Kamp'];
		 }

		if (!isset($arrNumPark))
		{
			$NumPark = 70;
		}
		else
		{
			$NumPark = $arrNumPark;
		}

		if (!isset($arrCsvName))
		{
			$csvName = 'default.csv';
		}
		else
		{
			$csvName = $arrCsvName;
		}

		$NeighPark = $Population * 0.2;
		$FreePark = floor($NumPark - $NeighPark);

		// euresi posostou apo kampili zitisis
		$csvData = file_get_contents($csvName);
		$lines = explode(PHP_EOL, $csvData);
		$array = array();
		foreach ($lines as $line) {
		    $array[] = str_getcsv($line);
		}
		//////////////////////////////////////////

		// apomonosi mono wras
		if ($time[0]==0)
		{
			$time = $time[1];
		}
		elseif ($time[0]==1)
		{
			$time = 10+$time[1];
		}
		elseif ($time[0]==2)
		{
			$time = 20+$time[1];
		}
		//////////////////////////////////////////

		$kampPercent = $array[$time][1] * $FreePark;
		$FreePark = floor($FreePark - $kampPercent);

		if ($NeighPark >= $NumPark)
		{
			$FreePark = 0;
			$NeighPark = $NumPark;
		}

		$PercNeighPark = 1 - ($FreePark/$NumPark);

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

		$return_arr[] = array("Color" => $Color,
                    "id" => $id,
                    "centroid" => $Centroid,
                    "percentage" => $PercNeighPark);

		echo json_encode($return_arr);

		//echo $Color;
?>