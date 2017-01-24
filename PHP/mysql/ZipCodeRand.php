<?php
function debug_to_console( $data ) {
	if ( is_array( $data ) )
		$output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
	else
		$output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
		print_r($output);
	}

$servername = "localhost";
$username = "xxxx";
$password = "xxxxxx";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    debug_to_console("Connection failed: " . $conn->connect_error);
} 

// Gets random zip code from db
$sql = "SELECT * FROM `zip_city_state`\n"
    . "ORDER BY RAND()\n"
    . "LIMIT 1";
$result = $conn->query($sql);
//Outputs database results
if ($result->num_rows > 0) {
  $ziparray = $result->fetch_assoc();
    $zip = $ziparray['zip'];
		$city = $ziparray['primary_city'];
		$state = $ziparray['state'];
		$arr = array('zipcode' => $zip, 'city' => $city, 'state' => $state);
		echo json_encode($arr);
//     echo $zip;
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>