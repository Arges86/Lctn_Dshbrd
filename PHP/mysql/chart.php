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

$servername = "localhost";
$username = "xxxx";
$password = "xxxxxx";
$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
//     debug_to_console("Connection failed: " . $conn->connect_error);
	} else {
// 		debug_to_console("Chart Generating...");
	}
// Queries database
$sql = "SELECT zip,\n"
    . "COUNT(zip) AS number\n"
    . "FROM ZipCode\n"
    . "GROUP BY zip\n"
    . "ORDER BY COUNT(zip) DESC"
		. " LIMIT 10";;
$result = $conn->query($sql);
//Outputs database results
if ($result->num_rows > 0) {
    // output data of each row
    echo "<script>
var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'bar',
    responsive: 'true',
    data: {
        labels: [";
    while($row = $result->fetch_assoc()) {
			$zipcode = $row["zip"];
			$zip = str_pad($zipcode, 5, "0", STR_PAD_LEFT);//Makes sure zipcodes are always 5 digits
      echo "'".$zip."', "; //Zip codes being inserted into X axis of graph
      }
        echo "],
        datasets: [{
            label: '# of times Zip Code Searched',
            data: [";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()) {
        echo "'".$row["number"]."', "; //Number of entries being insterted into Y axis of graph
      }
    echo "],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>";
} else {
    echo "0 results";
}
// Close connection
$conn->close();
?>
  </body> 
  </html>