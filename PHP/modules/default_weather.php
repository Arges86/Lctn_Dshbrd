<?php
$api = "84f4fc1bd9c9d1148d0262755bb6c7d2";
		$url = "http://api.openweathermap.org/data/2.5/weather?zip=";
		$unt = "imperial";
		$country = "us";
		//$response = file_get_contents("http://api.openweathermap.org/data/2.5/weather?zip=10566,us&APPID=84f4fc1bd9c9d1148d0262755bb6c7d2&units=imperial");
		$url1 = $url.$zip_code.",".$country."&APPID=".$api."&units=".$unt;
// 		debug_to_console("Weather URL: ".$url1);
		$response = file_get_contents($url.$zip_code.",".$country."&APPID=".$api."&units=".$unt);
		$weather = json_decode($response,true);
// 		debug_to_console("Weather Zip Code: ".$zip_code);
		debug_to_console("Weather Json: ".$response);
		//Location
			echo "In ".$weather['name']." its:";
				echo "<br>";
		//Temp.
			echo "Currently ".$weather['main']['temp']."&#x2109, ";
			echo "with a low of ".$weather['main']['temp_min']."&#x2109 ";
			echo "and a high of ".$weather['main']['temp_max']."&#x2109 today.";
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