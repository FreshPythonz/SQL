<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "taxicompany";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

echo $password;
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";

?>