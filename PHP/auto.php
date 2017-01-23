<!-- <small><center>Location Information from your Internet Service Provider</center></small> -->
<?php
function debug_to_console( $data ) {
	if ( is_array( $data ) )
		$output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
	else
		$output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
		print_r($output);
	}
//Displays Address Module
$ipinfojson =  file_get_contents("http://ipinfo.io/{$_SERVER['REMOTE_ADDR']}");
$ipinfoarray = json_decode($ipinfojson,true);
debug_to_console("IpInfo Array: ".$ipinfoarray);
//Getz city name from longitude & latitude
	$geocord = $ipinfoarray["loc"];
	debug_to_console("Coordinates: ".$geocord);
	$geoarray = explode(",", $geocord);
	$long = $geoarray[0];
	$lat = $geoarray[1];
	$latr = trim($long);
	$lonr = trim($lat);
	$urlgeo = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.$latr.','.$lonr.'&sensor=false';
	$jsongoogleapi = @file_get_contents($urlgeo);
	$dataarray = json_decode($jsongoogleapi);
	$status = $dataarray->status;
	debug_to_console("Location URL: ".$urlgeo);
	if($status=="OK"){
		//Get address from json data
			$location = $dataarray->results[0]->formatted_address;
		//Gets ZipCode from json data (used in modules)
			$zipend = strpos($jsongoogleapi,"postal_code");
			$zipstart = $zipend - 36;
			$zip_code = substr($jsongoogleapi,$zipstart,5);
			debug_to_console('Zip Code: '.$zip_code);
    }else{
			$location =  '';
    	}
	echo "<div class='col-md-10'><small>".$location."</small></div><div class='col-md-2'></div>";
	//Finds county 'function'
		$json = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=".$zip_code."&sensor=false");
  	$zip_code_array = json_decode($json, true);
		debug_to_console("Zip Code Array: ".$zip_code_array);
		$state = $zip_code_array['results'][0]['address_components'][3]['long_name'];
		$check3 = $zip_code_array['results'][0]['address_components'][3]['types'][0];
		$check4 = $zip_code_array['results'][0]['address_components'][4]['types'][0];
		if ($check3=="administrative_area_level_2"){
			$county1 = $zip_code_array['results'][0]['address_components'][3]['long_name'];
		} elseif ( $check4=="administrative_area_level_2" ) {
			$county1 = $zip_code_array['results'][0]['address_components'][4]['long_name'];
		} else {
			$county1 = $zip_code_array['results'][0]['address_components'][2]['long_name'];
		}
?>
<br><br>
<?php
//Image carousel module
	$county = trim($county1);
	if ($county == null) {
		$picture1 = "https://arges86.homeserver.com/how_to/img/Carousel1.jpg";
		$title1 = "Pine Meadow Lake, NY";
		$picture2 = "https://arges86.homeserver.com/how_to/img/Carousel2.jpg";
		$title2 = "Clarence Fahnestock Memorial State Park, NY";
		$picture3 = "https://arges86.homeserver.com/how_to/img/Carousel3.jpg";
		$title3 = "Top of Bear Mountain, NY";
	} else {
  	//Flickr Module
		$tag = str_replace(" ","+",$county);
		include 'modules/flickr.php';
	}
?>
<!--    Image carousel    -->
<?php
$id_type = "auto"; //variable to set div ID so the different modules don't overlap
include 'modules/Carousel.php'; 
?>
<!-- 			<div class="row2"> -->
				<div class="col-md-7">
					<div class="tabbable" id="tabs-506087">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#panel-894211" data-toggle="tab">Weather</a>
							</li>
							<li>
								<a href="#panel-663917" data-toggle="tab">Restaurants</a>
							</li>
							<li>
								<a href="#panel-poi" data-toggle="tab">Points of Interest</a>
							</li>
							<li>
								<a href="#panel-wiki" data-toggle="tab">Wikipedia</a>
							</li>
							<li>
								<a href="#panel-isp" data-toggle="tab">Your ISP</a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="panel-894211">
								<small><small>Weather provided by openweathermap.org<br></small></small>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="box1">
					<!-- Form is Here -->
					<div id="form-content">
						<form method="post" id="far-form" autocomplete="off">
							<div class="form-group">
								<button class="btn btn-primary" name="" id="mybutton5"><input type="hidden" name="degrees" value="<?php echo  $zip_code ?>,imperial") ><span class="glyphicon glyphicon-search"></span>&#8457;</button>               
						</form>
						<form method="post" id="cel-form" autocomplete="off">
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
			<div id="initialF">
			<?php
//Auto Weather Module
  $zip = trim($zip_code);
		if ($zip == "undefined") { //If zip code is undefined, skips this section
			echo "Failed to find your zip code. <br> I'm Sorry, you are going to have to enter it manually.<br>";
		} else {
	//Weather Service call
		include 'modules/default_weather.php';
		}
?>
			</div>
			<div id="Fahrenheit"></div>
			<span id="Celsius"></span>
		</div>
	</div>
	<script>
		$('#far-form').submit(function(e) {
			e.preventDefault(); // Prevent Default Submission
			$.ajax({
					url: 'PHP/weather.php',
					type: 'POST',
					data: $(this).serialize(), // it will serialize the form data
					dataType: 'html'
				})
				.done(function(data) {
					$('#initialF').fadeOut('slow', function() { // hides initial response, from ISP
						$('#Fahrenheit').fadeIn('slow').html(data); // Shows response from form submission
            $('#Celsius').hide();
					});
				})
				.fail(function() {
					$('#failure').show();
				});
		});    
    $('#cel-form').submit(function(e) {
			e.preventDefault(); // Prevent Default Submission
			$.ajax({
					url: 'PHP/weather.php',
					type: 'POST',
					data: $(this).serialize(), // it will serialize the form data
					dataType: 'html'
				})
				.done(function(data) {
					$('#initialF').fadeOut('slow', function() { // hides initial response, from ISP
						$('#Celsius').fadeIn('slow').html(data); // Shows response from form submission
            $('#Fahrenheit').hide();
					});
				})
				.fail(function() {
					$('#failure').show();
				});
		});
	</script>
							</div>
							<div class="tab-pane" id="panel-663917">
								<small><small>Pizza Restaurants & Reviews by Yellow Pages<br></small></small>
<?php
//Yellow Pages module
	include 'modules/yellow_pages.php';
?>
							</div>
							<div class="tab-pane" id="panel-poi">
								<small><small>Points of Interest by geonames.org<br></small></small>
<?php
	include 'modules/PointOfInterest.php';
?>
							</div>
							<div class="tab-pane" id="panel-wiki">
								<small><small>Wikipedia by geonames.org<br></small></small>
<?php
	include 'modules/wiki.php';
?>
							</div>
							<div class="tab-pane" id="panel-isp">
								<br>
<?php
	$info = $ipinfoarray["org"];
	$parts = (explode(" ",$info));
	$isp = $parts[1]. " " .$parts[2];
	$isplink = $parts[0];
	echo "Your ISP is <a href='http://ipinfo.io/".$isplink."'target='blank'>".$isp."</a>";
	echo "<br>";
	echo "This is where your address is coming from. <br> If this isn't correct, try the 'GPS Location' button or entering a zip code of your choice";
	echo "<br>";
	echo "<img class='img-responsive' src=https://arges86.homeserver.com/How_To/img/isp/". $parts[1] . ".jpg>";
debug_to_console("End of Auto Logs");
?>
							</div>
<script> //Adds touch support for carousel
  $(document).ready(function() {  
  		 $("#carousel-auto").swiperight(function() {  
    		  $(this).carousel('prev');  
	    		});  
		   $("#carousel-auto").swipeleft(function() {  
		      $(this).carousel('next');  
	   });  
	});  
</script>