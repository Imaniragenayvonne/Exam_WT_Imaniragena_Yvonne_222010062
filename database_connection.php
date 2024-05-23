<?php
// Connection details
$host = "localhost";
$user = "root";
$pass = "";
$database = "investment_advice_platform";
  


// Creating connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>