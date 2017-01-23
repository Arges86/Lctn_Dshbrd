<?php
$urlw = "http://api.geonames.org/findNearbyWikipediaJSON?lat=";
$wiki_response = file_get_contents($urlw.$latr."&lng=".$lonr."&username=arges86");
$wiki = json_decode($wiki_response,true);
//Checks if there are any entries
	$name1 = $wiki['geonames'][0];
	if (isset($name1)) {
		$wikilength = (count($wiki['geonames']))-1;
		debug_to_console("Number of wiki entries: ".($wikilength+1));
		for ($w = 0; $w <= $wikilength; $w++) {
			$wiki_url = $wiki['geonames'][$w]['wikipediaUrl'];
			echo "<ul><b><a href=http://".$wiki_url." target='_blank'>".$wiki['geonames'][$w]['title']."</a></b></ul>";
			echo "<li>Its ".$wiki['geonames'][$w]['distance']." miles from ".$zip_code."</li>";
			$wiki_lat = $wiki['geonames'][$w]['lat'];
			$wiki_lon = $wiki['geonames'][$w]['lng'];
			echo "<li>".$wiki['geonames'][$w]['summary']."</li><br>";
			//Displays map with long & lat locations
			echo '<div class="container">
					<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#wiki_'.$id_type.$w.'map">Map</button>
					<div id="wiki_'.$id_type.$w.'map" class="collapse">
						<iframe
							width="300"
							height="225"
							frameborder="0" style="border:0"
							src="https://www.google.com/maps/embed/v1/place?key=AIzaSyD-9IrvK4Oor3OSkLhewjFq5F0UB2U9SwE
								&q='.$wiki_lat.','.$wiki_lon.'" allowfullscreen>
						</iframe> </div> </div><br>';
			}
		} else { //Displays if there are no Wikipedia articles
			echo "I'm Sorry, there are no Wikipedia entries in your area.";
			}
?>