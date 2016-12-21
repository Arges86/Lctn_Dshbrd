<?php
function debug_to_console( $data ) {
	if ( is_array( $data ) )
		$output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
	else 
		$output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
		print_r($output);
	}
if( $_POST ){	
    $zip_code = $_POST['txt_zip'];
    $zip_code = strip_tags($zip_code);
	}
    ?>
<?php
//Image carousel module
	//Turns zipcode into town name
		$zip_code_array = json_decode(file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=".$zip_code."&sensor=false"),true);
		debug_to_console("Location URL: "."http://maps.googleapis.com/maps/api/geocode/json?address=".$zip_code."&sensor=false");
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
	//Get Latitude and Longitude from json data
		$latr = $zip_code_array['results'][0]['geometry']['location']['lat'];
		$lonr = $zip_code_array['results'][0]['geometry']['location']['lng'];
		debug_to_console("Coordinates: ".$latr.$lonr);
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
	include 'modules/flickr.php';
		}
?>
<!--    Image carousel    -->
<?php 
$id_type = "submit"; //variable to set div ID so the different modules don't overlap
include 'modules/Carousel.php'; 
?>
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
								<a href="#panel-manualpizza" data-toggle="tab">Restaurants</a>
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
							<!-- End of form -->
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- End Fahrenhiet & Celsius buttons -->
	<div class="container-fluid">
		<div class="alert alert-danger" id="failure" style="display:none;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Failure!</strong>I'm sorry, something went wrong. Please try again.
		</div>
		<div class="col-md-12">
			<div id="initialSubmit">
<?php
	//Weather Service call
		include 'modules/default_weather.php';
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
//Yellow Pages module
	include 'modules/yellow_pages.php';
?>
							</div>
							<div class="tab-pane" id="panel-manualpoi">
								<small><small>Points of Interest by geonames.org<br></small></small>
<?php
	include 'modules/PointOfInterest.php';
?>
					</div>
					<div class="tab-pane" id="panel-manualwiki">
						<small><small>Wikipedia by geonames.org<br></small></small>
 <?php
	include 'modules/wiki.php';
	debug_to_console("End of Submit Logs");
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
  		 $("#carousel-submit").swiperight(function() {  
    		  $(this).carousel('prev');  
	    		});  
		   $("#carousel-submit").swipeleft(function() {  
		      $(this).carousel('next');  
	   });  
	});  
</script>
