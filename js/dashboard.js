//Search Function
		$(document).ajaxStart(function() {
			$('#loader-wrapper').show();
			//$(".col-md-12").hide();
		}).ajaxStop(function() {
			$('#loader-wrapper').hide();
			$(".col-md-12").show(); //shows container after content has loaded (prevents stupid line from persisting on top of div box)
		});
		$("#initial").load("PHP/auto.php"); //Auto populated information
		$('#reg-form').submit(function(e) {
			e.preventDefault(); // Prevent Default Submission
			$.ajax({
					url: 'PHP/submit.php',
					type: 'POST',
					data: $(this).serialize(), // it will serialize the form data
					dataType: 'html'
				})
				.done(function(data) {
					$('#initial').fadeOut('slow', function() { // hides initial response, from ISP
						$('#response').fadeIn('slow').html(data); // Shows response from form submission
						$('#mybutton').hide(); // hides default submit button
						$('#mybutton3').hide(); //hides failure submit button
						$('#mybutton4').hide(); //hides GPS submit button
						$('#mybutton2').show(); // shows success submit button
						$('#failure').hide(); //hides failure warning
						//$('#browser_location').hide(); // Hides browser location button
						$('#location').hide(); // hides browser location box
						$('#user-result').empty(); //hides zip_code check
						$("#zipresponse").hide(); //hides random zipcodes' city, state
					});
				})
				.fail(function() {
					$('#failure').show();
					$('#loader-wrapper').hide(); //Hides loading icon
					$('#location').hide(); // hides browser location box
					$('#mybutton').hide(); // hides default submit button
					$('#mybutton2').hide(); // hides success submit button
					$('#mybutton3').show(); // shows faiure submit button
					$('#mybutton4').hide(); //hides GPS submit button
					$('#user-result').empty(); //hides zip_code check
					$("#zipresponse").hide(); //hides random zipcodes' city, state
				});
		});
		//Browser Location button
		$(document).ready(function() {
			$("#browser_location").click(function() {
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(showLocation);
				} else {
					$('#location').html('Geolocation is not supported by this browser.');
				}
				function showLocation(position) {
					var latitude = position.coords.latitude;
					var longitude = position.coords.longitude;
					$.ajax({
						type: 'POST',
						url: 'PHP/getLocation.php',
						data: 'latitude=' + latitude + '&longitude=' + longitude,
						success: function(msg) {
							if (msg) {
								$("#location").html(msg);
							} else {
								$("#location").html('Not Available');
							}
						}
					});
				}
				$('#location').show();
				$('#response').hide();
				$('#initial').hide();
				$('#failure').hide();
					$('#mybutton').hide(); // hides default submit button
					$('#mybutton2').hide(); // hides success submit button
					$('#mybutton3').hide(); // hides faiure submit button
					$('#mybutton4').show(); //shows GPS submit button
					$('#user-result').empty(); //hides zip_code check
					$("form").trigger('reset'); //deletes values in input form
					$("#zipresponse").hide(); //hides random zipcodes' city, state
			});
		});
//# sourceURL=pen.js
		$('.box1').matchHeight();
//checks if zip code exists. Throws warning if its missing. 
  $(document).ready(function() {
    var x_timer;
    $("#zipcode").keyup(function(e) {
      clearTimeout(x_timer);
      var zip_code = $(this).val();
      x_timer = setTimeout(function() {
        check_zipcode_ajax(zip_code);
      }, 1000);
    });
    function check_zipcode_ajax(zipcode) {
      $("#user-result").html('<img src="/images/ajax-loader.gif" />');
      $.post('PHP/zip-checker.php', {
        'zipcode': zipcode
      }, function(data) {
        $("#user-result").html(data);
				$('#user-result').show(); //shows zip_code check
      });
    }
  });		
	$('.disable-enter').keypress( //If zipcode doesn't exist, unable to press enter
    function(event){
     if (event.which == '13') {
        event.preventDefault();
      }
});
//Random ZipCode Button	
	$(document).ready(function() {
		$("#ZipRand").click(function() {
			jQuery.when(getRandomZip()).done(function(randomZipSuccessMessage) {
				$('input[name="txt_zip"]').val(randomZipSuccessMessage['zip']); //inserts zipcode into form
				$("#zipresponse").empty(); //deletes previous entry from div
				$("#zipresponse").show(); //shows it, other buttons hide this id
				$('#zipresponse').append(randomZipSuccessMessage['primary_city']+", "+randomZipSuccessMessage['state']); //inserts city & state name right below it
			}).fail(function() {
				$('#failure').show();
			});
		});
	});
	function getRandomZip() {
		return jQuery.ajax({
			dataType: "json",
			type: "GET",
			url: "PHP/mysql/ZipCodeRand.php",
			data: null,
			error: function(data, textStatus, errorThrown) {
				console.log("Error... " + data);
				console.log(textStatus);
				console.log(errorThrown);
			}
		});
	}
