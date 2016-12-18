	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="box1">
					<!-- Form is Here -->
					<div id="form-content">
						<form method="post" id="pizza-form<?php echo $id_type ?>" autocomplete="off">
							<div class="form-group">
								<button class="btn btn-primary" name="pizza" id="mybutton5"><input type="hidden" name="restaurant" value="<?php echo  $zip_code ?>,pizza") ><i class="material-icons" style="font-size:15px">local_pizza</i>Pizza</button>               
						</form>
						<form method="post" id="bar-form<?php echo $id_type ?>" autocomplete="off">
                <button class="btn btn-primary" name="bar" id="mybutton5"><input type="hidden" name="restaurant" value="<?php echo  $zip_code ?>,bar"><i class="material-icons" style="font-size:15px">local_bar</i>Bar</button>
						</form>
						<form method="post" id="cafe-form<?php echo $id_type ?>" autocomplete="off">
                <button class="btn btn-primary" name="cafe" id="mybutton5"><input type="hidden" name="restaurant" value="<?php echo  $zip_code ?>,cafe"><i class="material-icons" style="font-size:15px">local_cafe</i>Cafe</button>
						</form>
              </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End of form -->
	<div class="container-fluid">
		<div class="alert alert-danger" id="failureYP<?php echo $id_type ?>" style="display:none;"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Failure!</strong>I'm sorry, something went wrong. Please try again.
		</div>
		<div class="col-md-12">
			<div id="initialYP<?php echo $id_type ?>">
			<?php
  $zip = trim($zip_code);
		if ($zip == "undefined") { //If zip code is undefined, skips this section
			echo "Failed to find your zip code. <br> I'm Sorry, you are going to have to enter it manually.<br>";
		} else {
	//Yellow Pages Service call
		include 'yellow_pages/default_yp.php';
		}
?>
			</div>
			<span id="Pizza<?php echo $id_type ?>"></span>
			<span id="Bar<?php echo $id_type ?>"></span>
			<span id="Cafe<?php echo $id_type ?>"></span>
		</div>
	</div>
	<script>
		$('#pizza-form<?php echo $id_type ?>').submit(function(e) {
			e.preventDefault(); // Prevent Default Submission
			$.ajax({
					url: 'PHP/modules/yellow_pages/button_yp.php',
					type: 'POST',
					data: $(this).serialize(), // it will serialize the form data
					dataType: 'html'
				})
				.done(function(data) {
					$('#initialYP<?php echo $id_type ?>').fadeOut('slow', function() { // hides initial response, from ISP
						$('#Pizza<?php echo $id_type ?>').fadeIn('slow').html(data); // Shows response from form submission
            $('#Bar<?php echo $id_type ?>').hide();
						$('#Cafe<?php echo $id_type ?>').hide();
					});
				})
				.fail(function() {
					$('#failureYP<?php echo $id_type ?>').show();
				});
		});    
    $('#bar-form<?php echo $id_type ?>').submit(function(e) {
			e.preventDefault(); // Prevent Default Submission
			$.ajax({
					url: 'PHP/modules/yellow_pages/button_yp.php',
					type: 'POST',
					data: $(this).serialize(), // it will serialize the form data
					dataType: 'html'
				})
				.done(function(data) {
					$('#initialYP<?php echo $id_type ?>').fadeOut('slow', function() { // hides initial response, from ISP
						$('#Bar<?php echo $id_type ?>').fadeIn('slow').html(data); // Shows response from form submission
            $('#Pizza<?php echo $id_type ?>').hide();
						$('#Cafe<?php echo $id_type ?>').hide();
					});
				})
				.fail(function() {
					$('#failureYP<?php echo $id_type ?>').show();
				});
		});
		$('#cafe-form<?php echo $id_type ?>').submit(function(e) {
			e.preventDefault(); // Prevent Default Submission
			$.ajax({
					url: 'PHP/modules/yellow_pages/button_yp.php',
					type: 'POST',
					data: $(this).serialize(), // it will serialize the form data
					dataType: 'html'
				})
				.done(function(data) {
					$('#initialYP<?php echo $id_type ?>').fadeOut('slow', function() { // hides initial response, from ISP
						$('#Cafe<?php echo $id_type ?>').fadeIn('slow').html(data); // Shows response from form submission
            $('#Pizza<?php echo $id_type ?>').hide();
						$('#Bar<?php echo $id_type ?>').hide();
					});
				})
				.fail(function() {
					$('#failureYP<?php echo $id_type ?>').show();
				});
		});
	</script>
<!--End of Buttons -->