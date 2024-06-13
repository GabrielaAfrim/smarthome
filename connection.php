<?php
// Database connection parameters
$host = "127.0.0.1";
$username = "Gabriela";
$password = "1550gaboshe";
$database = "database_webpage";

// Create connection
$con = new mysqli($host, $username, $password, $database);

$query_str = "INSERT INTO users_mysmarthome (user_name, password) VALUES (?, ?)";


// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>

