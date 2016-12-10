<?php
	$var_value = $_POST['degrees'];
	$arr_value = (explode(",",$var_value));
	$zip_code= $arr_value[0];
	$unt = $arr_value[1];
	//Weather Service call
		$api = "84f4fc1bd9c9d1148d0262755bb6c7d2";
		$url = "http://api.openweathermap.org/data/2.5/weather?zip=";
		//$unt = "imperial";
		$country = "us";
		//$response = file_get_contents("http://api.openweathermap.org/data/2.5/weather?zip=10566,us&APPID=84f4fc1bd9c9d1148d0262755bb6c7d2&units=imperial");
		$responsew = file_get_contents($url.$zip_code.",".$country."&APPID=".$api."&units=".$unt);
		$weather = json_decode($responsew,true);
		//Location
			echo "In ".$weather['name']." its:";
				echo "<br>";
		//Temp.
			switch ($unt) { //Picks unit of measurement 
				case "imperial":
					$unit ="&#8457;";
					break;
				case "metric":
					$unit="&#8451;";
					break;
				}
			echo "Currently ".$weather['main']['temp'].$unit.", ";
			echo "with a low of ".$weather['main']['temp_min'].$unit." ";
			echo "and a high of ".$weather['main']['temp_max'].$unit." today.";
			echo "<br>";
		//Rain amount
			if (empty($weather['rain']['3h'])) {
    		echo 'With no rain in the last 3 hours';
					echo "<br>";
				} else {
				echo "There's been ".$weather['rain']['3h']." inches of rain in the last 3 hours";
					echo "<br>";
				}
			//snow amount
			if (empty($weather['snow']['3h'])) {
    		echo 'With no snow in the last 3 hours';
					echo "<br>";
				} else {
				echo "There's been ".$weather['rain']['3h']. "inches of rain in the last 3 hours";
					echo "<br>";
				}
		//Cloud cover
			echo "Cloud cover is ".$weather['clouds']['all']."% ";
		//Description
			echo "with ".$weather['weather'][0]['description']."<img src='https://openweathermap.org/img/w/".$weather['weather'][0]['icon'].".png'>";
				echo "<br>";
		//Time weather was updated
			$epoch =  $weather['dt'];
			$dt = new DateTime("@$epoch");  // convert UNIX timestamp to PHP DateTime
			echo "<small>Weather as of ".$dt->format('Y/M/d H:i:s')."</small>"; // output = 2012/08/15 00:00:00 
?>