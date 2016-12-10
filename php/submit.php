<?php
if( $_POST ){	
    $zip_code = $_POST['txt_zip'];
	}
    ?>
<?php
//Image carousel module
	//Turns zipcode into town name
		$zip_code_array = json_decode(file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=".$zip_code."&sensor=false"),true);
		$check3 = $zip_code_array['results'][0]['address_components'][3]['types'][0];
		$check4 = $zip_code_array['results'][0]['address_components'][4]['types'][0];
		if ($check3=="administrative_area_level_2"){
			$county1 = $zip_code_array['results'][0]['address_components'][3]['long_name'];
		} elseif ( $check4=="administrative_area_level_2" ) {
			$county1 = $zip_code_array['results'][0]['address_components'][4]['long_name'];
		} else {
			$county1 = $zip_code_array['results'][0]['address_components'][2]['long_name'];
		}
		$tag = str_replace(" ","+",$county1);		
	//Get address from json data
    $status = $zip_code_array['status'];
		if($status=="OK"){
			$location = $zip_code_array['results'][0]['formatted_address'];
    }else{
        $location =  '';
    }
		echo "<small>".$location."</small>";
		echo " <br><br>";
	//If Zip Code can't be turned into a State, displays three photos I took instead
		$state = $zip_code_array['results'][0]['address_components'][3]['long_name'];
		if ($state == null) {
			$picture1 = "https://arges86.homeserver.com/how_to/img/Carousel1.jpg";
			$title1 = "Pine Meadow Lake, NY";
			$picture2 = "https://arges86.homeserver.com/how_to/img/Carousel2.jpg";
			$title2 = "Clarence Fahnestock Memorial State Park, NY";
			$picture3 = "https://arges86.homeserver.com/how_to/img/Carousel3.jpg";
			$title3 = "Top of Bear Mountain, NY";
			} else {
  //Flickr Module
    $api_key = '96cbe4cb0d6f28b358b00a0985199cc8'; 
    $perPage = 3; //number of pictures per page
    $url = 'https://api.flickr.com/services/rest/?method=flickr.photos.search';
    $url.= '&api_key='.$api_key;
    $url.= '&tags='.$tag;
    $url.= '&per_page='.$perPage;
    $url.= '&format=json'; //format of response
    $url.= '&nojsoncallback=1';
    $url.= '&page='.rand(1, 15); //which page to use (randomly picked)
    //$url.='&geo_context=2';
    $responseflickr = json_decode(file_get_contents($url),true);
	  $picture1 = "https://farm".$responseflickr['photos']['photo'][0]['farm'].".staticflickr.com/".$responseflickr['photos']['photo'][0]['server']."/".$responseflickr['photos']['photo'][0]['id']."_".$responseflickr['photos']['photo'][0]['secret'].".jpg";
    $title1 = $responseflickr['photos']['photo'][0]['title'];
    $picture2 = "https://farm".$responseflickr['photos']['photo'][1]['farm'].".staticflickr.com/".$responseflickr['photos']['photo'][1]['server']."/".$responseflickr['photos']['photo'][1]['id']."_".$responseflickr['photos']['photo'][1]['secret'].".jpg";
    $title2 = $responseflickr['photos']['photo'][1]['title'];
    $picture3 = "https://farm".$responseflickr['photos']['photo'][2]['farm'].".staticflickr.com/".$responseflickr['photos']['photo'][2]['server']."/".$responseflickr['photos']['photo'][2]['id']."_".$responseflickr['photos']['photo'][2]['secret'].".jpg";
    $title3 = $responseflickr['photos']['photo'][2]['title'];
		}
?>
<!--    Image carousel    -->
				<div class="col-md-5">
					<small><small><center><?php 
						if ($state == null) {
							echo "Zip Code not found, So here are three random pictures from my local area. Enjoy"; 
						}else {
							echo "Pictures from ".$county1.". Pulled from Flickr"; } ?>
					</center></small></small>
					<div class="carousel slide" id="carousel-manual">
						<ol class="carousel-indicators">
							<li class="active" data-slide-to="0" data-target="#carousel-manual">
							</li>
							<li data-slide-to="1" data-target="#carousel-manual">
							</li>
							<li data-slide-to="2" data-target="#carousel-manual">
							</li>
						</ol>
						<div class="carousel-inner">
							<div class="item active">
								<img alt="Carousel Bootstrap First" src="<?php echo $picture1; ?>" />
								<div class="carousel-caption">
									<p>
										<?php echo $title1; ?>
									</p> 
								</div>
							</div>
							<div class="item">
								<img alt="Carousel Bootstrap Second" src="<?php echo $picture2; ?>" />
								<div class="carousel-caption">
									<p>
										<?php echo $title2; ?>
									</p>
								</div>
							</div>
							<div class="item">
								<img alt="Carousel Bootstrap Third" src="<?php echo $picture3; ?>" />
								<div class="carousel-caption">
									<p>
										<?php echo $title3; ?>
									</p>
								</div>
							</div>
						</div> <a class="left carousel-control" href="#carousel-manual" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#carousel-manual" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
					</div>
				</div>
			</div>
<!-- 			<div class="row2"> -->
				<div class="col-md-1">
				</div>
				<div class="col-md-5">
					<div class="tabbable" id="tabs-506087">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#panel-manualweather" data-toggle="tab">Weather</a>
							</li>
							<li>
								<a href="#panel-manualpizza" data-toggle="tab">Pizza Places</a>
							</li>
							<li>
								<a href="#panel-manualpoi" data-toggle="tab">Points of Interest</a>
							</li>
							<li>
								<a href="#panel-manualwiki" data-toggle="tab">Wikipedia</a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="panel-manualweather">
								<small><small>Weather provided by openweathermap.org<br></small></small>
<!-- Begin Fahrenhiet & Celsius buttons -->
<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="box1">
					<!-- Form is Here -->
					<div id="form-content">
						<form method="post" id="far-formSubmit" autocomplete="off">
							<div class="form-group">
								<button class="btn btn-primary" name="" id="mybutton5"><input type="hidden" name="degrees" value="<?php echo  $zip_code ?>,imperial") ><span class="glyphicon glyphicon-search"></span>&#8457;</button>               
						</form>
						<form method="post" id="cel-formSubmit" autocomplete="off">
                <button class="btn btn-primary" name="degrees" id="mybutton5"><input type="hidden" name="degrees" value="<?php echo  $zip_code ?>,metric"><span class="glyphicon glyphicon-search"></span>&#x2103;</button>
              </form>
              </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End of form -->
	<div class="container-fluid">
		<div class="alert alert-danger" id="failure" style="display:none;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Failure!</strong>I'm sorry, something went wrong. Please try again.
		</div>
		<div class="col-md-12" style="display:none;">
			<div id="initialSubmit">
<!-- End Fahrenhiet & Celsius buttons -->
<?php
	//Weather Service call
		$api = "84f4fc1bd9c9d1148d0262755bb6c7d2";
		$url = "http://api.openweathermap.org/data/2.5/weather?zip=";
		$unt = "imperial";
		$country = "us";
		//$response = file_get_contents("http://api.openweathermap.org/data/2.5/weather?zip=10566,us&APPID=84f4fc1bd9c9d1148d0262755bb6c7d2&units=imperial");
		$responsew = file_get_contents($url.$zip_code.",".$country."&APPID=".$api."&units=".$unt);
		$weather = json_decode($responsew,true);
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
							</div>
			<div id="FahrenheitSubmit"></div>
			<span id="CelsiusSubmit"></span>
		</div>
	</div>
	<script>
		$('#far-formSubmit').submit(function(e) {
			e.preventDefault(); // Prevent Default Submission
			$.ajax({
					url: 'PHP/weather.php',
					type: 'POST',
					data: $(this).serialize(), // it will serialize the form data
					dataType: 'html'
				})
				.done(function(data) {
					$('#initialSubmit').fadeOut('slow', function() { // hides initial response, from ISP
						$('#FahrenheitSubmit').fadeIn('slow').html(data); // Shows response from form submission
            $('#CelsiusSubmit').hide();
					});
				})
				.fail(function() {
					$('#failure').show();
				});
		});    
    $('#cel-formSubmit').submit(function(e) {
			e.preventDefault(); // Prevent Default Submission
			$.ajax({
					url: 'PHP/weather.php',
					type: 'POST',
					data: $(this).serialize(), // it will serialize the form data
					dataType: 'html'
				})
				.done(function(data) {
					$('#initialSubmit').fadeOut('slow', function() { // hides initial response, from ISP
						$('#CelsiusSubmit').fadeIn('slow').html(data); // Shows response from form submission
            $('#FahrenheitSubmit').hide();
					});
				})
				.fail(function() {
					$('#failure').show();
				});
		});
	</script>
							</div>
							<div class="tab-pane" id="panel-manualpizza">
								<small><small>Pizza Restaurants & Reviews by Yellow Pages<br></small></small>
<?php
//Pizza place manual entry module
	// put your API key here
		$apikey = "xp6c2m7cvz"; 
	// location of the search API endpoint
		$endpoint = "http://api2.yp.com/listings/v1/search?searchloc=".$zip_code."&term=pizza&format=json&sort=distance&radius=5&listingcount=2";
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
							</div>
							<div class="tab-pane" id="panel-manualpoi">
								<small><small>Points of Interest by geonames.org<br></small></small>
<?php
//Point of Interest Manual Entry Module
	$lon = $response_pizza_array1['searchResult']['metaProperties']['searchLon'];
	$lonr = round($lon,4);
	$lat = $response_pizza_array1['searchResult']['metaProperties']['searchLat'];
	$latr = round($lat,4);
	$url = "http://api.geonames.org/findNearbyPOIsOSMJSON?lat=";
	//$response = file_get_contents("http://api.geonames.org/findNearbyPOIsOSMJSON?lat=40.7128&lng=-74.0059&radius=1&username=arges86");
	$poi_response = file_get_contents($url.$latr."&lng=".$lonr."&radius1&username=arges86");
	$poi = json_decode($poi_response,true);
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
						<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#poi'.$x.'map">Map</button>
						<div id="poi'.$x.'map" class="collapse">
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
					</div>
					<div class="tab-pane" id="panel-manualwiki"><br>
 <?php
//Wikipedia Manual Entry Module
    //"http://api.geonames.org/findNearbyWikipedia?lat=41.2916113&lng=-73.91834640000002&username=arges86"
    $urlw = "http://api.geonames.org/findNearbyWikipediaJSON?lat=";
    $wiki_response = file_get_contents($urlw.$lat."&lng=".$lon."&username=arges86");
    $wiki = json_decode($wiki_response,true);
		$WikiStatus = $wiki['geonames'][0]['summary'];
		if (isset($WikiStatus)) {
    $wikilength = (count($wiki['geonames']))-1;
    for ($z = 0; $z <= $wikilength; $z++) {
			$wiki_url = $wiki['geonames'][$z]['wikipediaUrl'];
			echo "<ul><b><a href=http://".$wiki_url." target='_blank'>".$wiki['geonames'][$z]['title']."</a></b></ul>";
			echo "<li>Its ".$wiki['geonames'][$z]['distance']." miles from ".$zip_code."</li>";
			$wiki_lat = $wiki['geonames'][$z]['lat'];
			$wiki_lon = $wiki['geonames'][$z]['lng'];
			echo "<li>".$wiki['geonames'][$z]['summary']."</li><br>";
			//Displays map with long & lat locations
			echo '<div class="container">
					<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#wiki'.$z.'map">Map</button>
					<div id="wiki'.$z.'map" class="collapse">
						<iframe
							width="300"
							height="225"
							frameborder="0" style="border:0"
							src="https://www.google.com/maps/embed/v1/place?key=AIzaSyD-9IrvK4Oor3OSkLhewjFq5F0UB2U9SwE
								&q='.$wiki_lat.','.$wiki_lon.'" allowfullscreen>
						</iframe> </div> </div><br>';
    } } else {
			echo "There are no Wikipedia Articles in that area.";
		}
  ?>
					</div>
						</div>
					</div>
				</div>
				<div class="col-md-1">
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
<!-- 		</table> -->
<script> //Adds touch support for carousel
  $(document).ready(function() {  
  		 $("#carousel-manual").swiperight(function() {  
    		  $(this).carousel('prev');  
	    		});  
		   $("#carousel-manual").swipeleft(function() {  
		      $(this).carousel('next');  
	   });  
	});  
</script>