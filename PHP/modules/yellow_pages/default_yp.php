<?php
	// put your API key here
		$apikey = "xp6c2m7cvz"; 
	// location of the search API endpoint
		$endpoint = "http://api2.yp.com/listings/v1/search?searchloc=".$zip_code."&term=Pizza&format=json&sort=distance&radius=5&listingcount=2";
		$url = $endpoint . "&key=" . $apikey;
	// call the endpoint
		$UserAgent = $_SERVER['HTTP_USER_AGENT'];
		$options  = array( 'http' => array( 'user_agent' => $UserAgent) );
		$context  = stream_context_create($options);
		$response_pizza1 = file_get_contents($url,false,$context);
		$response_pizza_array1 = json_decode($response_pizza1,true);
  //Checks 'listingCount'
    $listingCount = $response_pizza_array1['searchResult']['metaProperties']['listingCount'];
    $listing = trim($listingCount);
  //If Statement. Displays a sorry message if the 'zip code' isn't there (aka listingCount of 0)
    if ($listing >= 1) {
		//Turns zipcode into town name
			$zip_code_array = json_decode(file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=".$zip_code."&sensor=false"),true);
			$town_name = $zip_code_array['results'][0]['address_components'][1]['long_name'];
  //First Pizza Place
			echo "The closest pizza joint to ".$town_name." is <a href=".$response_pizza_array1['searchResult']['searchListings']['searchListing'][0]['businessNameURL']." target='_blank'> ".$response_pizza_array1['searchResult']['searchListings']['searchListing'][0]['businessName'].".</a><br>";
			echo "They are located on ".$response_pizza_array1['searchResult']['searchListings']['searchListing'][0]['street']." ";
			echo $response_pizza_array1['searchResult']['searchListings']['searchListing'][0]['city']." ";
			echo $response_pizza_array1['searchResult']['searchListings']['searchListing'][0]['state']."<br>";
			echo ' <a href="tel:'.$response_pizza_array1['searchResult']['searchListings']['searchListing'][0]['phone'].'"><span class="glyphicon glyphicon-earphone"></span>'.$response_pizza_array1['searchResult']['searchListings']['searchListing'][0]['phone'].'</a><br>';
			$hours1 = $response_pizza_array1['searchResult']['searchListings']['searchListing'][0]['openHours'];
				if (empty($hours1)){	
					echo "";
					} else { echo "<small>Hours are ".$hours1."</small><br>"; }
			//Gets the rating
				$ratings = $response_pizza_array1['searchResult']['searchListings']['searchListing'][0]['averageRating'];
				$ratingsi = (int)$ratings;
				$rating = (float)$ratingsi;
				echo "Store's average rating is ".$rating." out of 5. ";
				echo "<small>(Out of ".$response_pizza_array1['searchResult']['searchListings']['searchListing'][0]['ratingCount']." reviews.)</small>";
				//Displays $rating's star equivalent
				echo "<div class='result-rating-".$rating."'></div><br>";
		//Second Pizza place
			$pbn2a = $response_pizza_array1['searchResult']['searchListings']['searchListing'][1]['businessName'];
			if (isset($pbn2a)) {
				echo "The 2nd closest pizza joint to ".$town_name." is <a href=".$response_pizza_array1['searchResult']['searchListings']['searchListing'][1]['businessNameURL']." target='blank'>".$pbn2a.".</a><br>";
				echo "They are located on ".$response_pizza_array1['searchResult']['searchListings']['searchListing'][1]['street']." ";
				echo $response_pizza_array1['searchResult']['searchListings']['searchListing'][1]['city']." ";
				echo $response_pizza_array1['searchResult']['searchListings']['searchListing'][1]['state']."<br>";
				echo ' <a href="tel:'.$response_pizza_array1['searchResult']['searchListings']['searchListing'][1]['phone'].'"><span class="glyphicon glyphicon-earphone"></span>'.$response_pizza_array1['searchResult']['searchListings']['searchListing'][1]['phone'].'</a><br>';
				$hours2 = $response_pizza_array1['searchResult']['searchListings']['searchListing'][1]['openHours'];
				if (empty($hours2)){	
					echo "";
					} else { echo "<small>Hours are ".$hours2."</small><br>"; }
				//Gets the rating
					$ratingsa = $response_pizza_array1['searchResult']['searchListings']['searchListing'][1]['averageRating'];
					$ratingsia = (int)$ratingsa;
					$ratinga = (float)$ratingsia;
					echo "Store's average rating is ".$ratinga." out of 5. ";
					echo "<small>(Out of ".$response_pizza_array1['searchResult']['searchListings']['searchListing'][1]['ratingCount']." reviews.)</small>";
					//Displays $rating's star equivalent
					echo "<div class='result-rating-".$ratinga."'></div><br>";
			} else { echo " ";}
				} else {
				echo "Sorry, your zip code of ".$zip_code." does not appear to be listed.";
    		}
		echo "<br>";
?>