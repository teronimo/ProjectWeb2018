<?php

		include_once 'db_connect.php';

		$time=$_POST['time'];
		$id=$_POST['id'];
		$NumPark = 70;
		$tmpPopulation = $con->query("SELECT population FROM map WHERE id = '$id'");
		$Population = 0;
		 while($row = $tmpPopulation->fetch_assoc()) 
		 {
		 	$Population=$row['population'];
		 }
		//$Population = rand(0,330);
		$NeighPark = $Population * 0.2;
		$FreePark = floor($NumPark - $NeighPark);

		// euresi posostou apo kampili zitisis
		$csvData = file_get_contents('default.csv');
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
		echo $Color;
?>