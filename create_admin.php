<?php
$mysqli = new mysqli("127.0.0.1", "GA", "1550gaboshe", "database_webpage");

// Kontrollera anslutningen
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$user_name = 'admin';
$password = password_hash('1550gaboshe', PASSWORD_DEFAULT);
$role = 'admin';

$query_str = "INSERT INTO users_mysmarthome (user_name, password, role) VALUES ('$user_name', '$password', '$role')";

if ($mysqli->query($query_str) === TRUE) {
    echo "Admin user created successfully.";
} else {
    echo "Error: " . $mysqli->error;
}

$mysqli->close();
?>
