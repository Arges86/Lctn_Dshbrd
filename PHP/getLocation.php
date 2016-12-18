<?php
function debug_to_console( $data ) {
	if ( is_array( $data ) )
		$output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
	else
		$output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
		echo $output;
	}
if(!empty($_POST['latitude']) && !empty($_POST['longitude'])){
    //Send request and receive json data by latitude and longitude
    $latr = trim($_POST['latitude']);
    $lonr = trim($_POST['longitude']);
		debug_to_console("Coordinates: ".$latr.",".$lonr);
    $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.$latr.','.$lonr.'&sensor=false';
    debug_to_console("URL: ".$url);
		$json = @file_get_contents($url);
    $data = json_decode($json);
    $status = $data->status;
    if($status=="OK"){
        //Get address from json data
        $location = $data->results[0]->formatted_address;
    }else{
        $location =  '';
    }
    //Print address 
    echo "<small>".$location."</small>";
    echo "<br>";
    $zipend = strpos($json,"postal_code");
    $zipstart = $zipend - 36;
    $zip_code = substr($json,$zipstart,5);
    echo "<br>";
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
		include 'modules/flickr.php';
		}
?>
		<!--    Image carousel    -->
		<?php 
$id_type = "getLocation"; //variable to set div ID so the different modules don't overlap
include 'modules/Carousel.php'; 
?>
		<div class="row2">
			<div class="col-md-1">
			</div>
			<div class="col-md-5">
				<div class="tabbable" id="tabs-506087">
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#weather-browser" data-toggle="tab">Weather</a>
						</li>
						<li>
							<a href="#pizza_browser" data-toggle="tab">Restaurants</a>
						</li>
						<li>
							<a href="#poi_browser" data-toggle="tab">Points of Interest</a>
						</li>
						<li>
							<a href="#wiki_browser" data-toggle="tab">Wikipedia</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="weather-browser">
							<small><small>Weather provided by openweathermap.org<br></small></small>
							<div class="container-fluid">
								<div class="row">
									<div class="col-md-12">
										<div class="box1">
											<!-- Form is Here -->
											<div id="form-content">
												<form method="post" id="far-formGetLocation" autocomplete="off">
													<div class="form-group">
														<button class="btn btn-primary" name="" id="mybutton5"><input type="hidden" name="degrees" value="<?php echo  $zip_code ?>,imperial") ><span class="glyphicon glyphicon-search"></span>&#8457;</button>
												</form>
												<form method="post" id="cel-formGetLocation" autocomplete="off">
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
									<div id="initialGetLocation">
										<?php
// Weather Module
  $zip = trim($zip_code);
		if ($zip == "undefined") { //If zip code is undefined, skips this section
			echo "Failed to find your zip code. <br> I'm Sorry, you are going to have to enter it manually.<br>";
		} else {
	//Weather Service call
		include 'modules/default_weather.php';
  }
?>
									</div>
									<div id="FahrenheitGetLocation"></div>
									<span id="CelsiusGetLocation"></span>
								</div>
							</div>
							<script>
								$('#far-formGetLocation').submit(function(e) {
									e.preventDefault(); // Prevent Default Submission
									$.ajax({
											url: 'PHP/weather.php',
											type: 'POST',
											data: $(this).serialize(), // it will serialize the form data
											dataType: 'html'
										})
										.done(function(data) {
											$('#initialGetLocation').fadeOut('slow', function() { // hides initial response, from ISP
												$('#FahrenheitGetLocation').fadeIn('slow').html(data); // Shows response from form submission
												$('#CelsiusGetLocation').hide();
											});
										})
										.fail(function() {
											$('#failure').show();
										});
								});
								$('#cel-formGetLocation').submit(function(e) {
									e.preventDefault(); // Prevent Default Submission
									$.ajax({
											url: 'PHP/weather.php',
											type: 'POST',
											data: $(this).serialize(), // it will serialize the form data
											dataType: 'html'
										})
										.done(function(data) {
											$('#initialGetLocation').fadeOut('slow', function() { // hides initial response, from ISP
												$('#CelsiusGetLocation').fadeIn('slow').html(data); // Shows response from form submission
												$('#FahrenheitGetLocation').hide();
											});
										})
										.fail(function() {
											$('#failure').show();
										});
								});
							</script>
						</div>
						<div class="tab-pane" id="pizza_browser">
							<small><small>Pizza Restaurants & Reviews by Yellow Pages<br></small></small>
							<?php
//Yellow Pages module
	include 'modules/yellow_pages.php';
?>
						</div>
						<div class="tab-pane" id="poi_browser">
							<small><small>Points of Interest by geonames.org<br></small></small>
<?php
	include 'modules/PointOfInterest.php';
?>
						</div>
						<div class="tab-pane" id="wiki_browser">
							<small><small>Wikipedia by geonames.org<br></small></small>
<?php
	include 'modules/wiki.php';
	debug_to_console("End of getLocation Logs");
?>
								<script>
									//Adds touch support for carousel
									$(document).ready(function() {
										$("#carousel-getLocation").swiperight(function() {
											$(this).carousel('prev');
										});
										$("#carousel-getLocation").swipeleft(function() {
											$(this).carousel('next');
										});
									});
								</script>