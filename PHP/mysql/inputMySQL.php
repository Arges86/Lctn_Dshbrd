<?php
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
// Inserts into databse
$zip_code = str_pad($zip_code, 5, "0", STR_PAD_LEFT);
$sql = "INSERT INTO `ZipCode`(`zip`) VALUES (".$zip_code.")";
// Return of successful
if ($conn->query($sql) === TRUE) {
    debug_to_console("Variable is a: ".gettype($zip_code));
    debug_to_console("New record of ".$zip_code." created successfully");
} else {
    debug_to_console("Error: " . $sql . "<br>" . $conn->error);
}
// Close connection
$conn->close();
?>