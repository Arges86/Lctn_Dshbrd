<?php
	$url = "http://api.geonames.org/findNearbyPOIsOSMJSON?lat=";
	//$response = file_get_contents("http://api.geonames.org/findNearbyPOIsOSMJSON?lat=40.7128&lng=-74.0059&radius=1&username=arges86");
	$poi_response = file_get_contents($url.$latr."&lng=".$lonr."&radius1&username=arges86");
	$poi = json_decode($poi_response,true);
  debug_to_console("POI URL: ".$url.$latr."&lng=".$lonr."&radius1&username=arges86");
  debug_to_console("Point of Interest: ".$poi);
	$poi0 =  $poi['poi']['name']; //gets name of POI if there is only one result 
	$poi1 =  $poi['poi'][0]['name']; //gets name of 1st POI if there are multiple results
	//Displays POI of multiple results
	if (isset($poi1)) {
	 $poilength = (count($poi['poi']))-1;
	 for ($x = 0; $x <= $poilength; $x++) {
			$name = $poi['poi'][$x]['typeName'];
			//Replaces the OpenStreetMap tag with common names, or just removes the underscore (http://wiki.openstreetmap.org/wiki/Map_Features)
					$geo_name = array("bicycle_parking","fast_food","convenience","dry_cleaning","video_games","_"); //leave "_" on the end
					$common_name = array("bicycle parking lot","fast food restaurant","convenience store","dry cleaner","video game store"," ");
					$namer = str_replace($geo_name,$common_name,$name);
			echo "<ul>There is a ".$namer.", ";
			echo $poi['poi'][$x]['name']."<br>";
			echo "<li>Its ".$poi['poi'][$x]['distance']." miles from ".$zip_code."</li></ul>";
				$lats = $poi['poi'][$x]['lat'];
				$lons = $poi['poi'][$x]['lng'];
			//Displays map with long & lat locations
			echo '<div class="container">
						<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#poi'.$id_type.$x.'map">Map</button>
						<div id="poi'.$id_type.$x.'map" class="collapse">
							<iframe
								width="300"
								height="225"
								frameborder="0" style="border:0"
								src="https://www.google.com/maps/embed/v1/place?key=AIzaSyD-9IrvK4Oor3OSkLhewjFq5F0UB2U9SwE
									&q='.$lats.','.$lons.'" allowfullscreen>
							</iframe> </div> </div><br>';
				if($x == 3) { // limits loop at 4 items
			break;
		}
		}
		} else {
			//Displays POI if only 1 result
			if (isset($poi0)) {
				echo "<ul>There is a ".$poi['poi']['typeName'].", ";
				echo $poi0." ";
				echo "<li>Its ".$poi['poi']['distance']." miles from ".$zip_code."</li></ul>";
				$latm = $poi['poi']['lat'];
				$lonm = $poi['poi']['lng'];
				//Dispalys map with long & lat locations
				echo '<iframe
					width="300"
					height="225"
					frameborder="0" style="border:0"
					src="https://www.google.com/maps/embed/v1/place?key=AIzaSyD-9IrvK4Oor3OSkLhewjFq5F0UB2U9SwE
						&q='.$latm.','.$lonm.'" allowfullscreen>
					</iframe>';
			} else {
				//Statement if no POI show up
				echo "There is nothing of interest in your area.";
			}
	}
?>