<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="https://arges86.homeserver.com/icons/Location%20Program.ico" type="image/x-icon">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.js"></script>
</head>
  <body>
    <canvas id="myChart" width="400" height="auto"></canvas>
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
// Queries database
$sql = "SELECT zip,\n"
    . "COUNT(zip) AS number\n"
    . "FROM ZipCode\n"
    . "GROUP BY zip\n"
    . "ORDER BY COUNT(zip) DESC"
		. " LIMIT 10";
$result = $conn->query($sql);
//Outputs database results
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
			$zipcode = $row["zip"];
			$zip = str_pad($zipcode, 5, "0", STR_PAD_LEFT);//Makes sure zipcodes are always 5 digits
      echo $zip." ";
      }
        echo '<br>';
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        echo $row["number"].", ";
      }
} else {
    echo "0 results";
}
// Close connection
$conn->close();
?>
  </body> 
  </html>