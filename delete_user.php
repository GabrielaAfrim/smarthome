<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Access denied!";
    exit();
}

$mysqli = new mysqli("127.0.0.1", "GA", "1550gaboshe", "database_webpage");

// Kontrollera anslutningen
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$user_id = $_GET['id'];

// Konstruera SQL-frågan för att ta bort användaren
$query_str = "DELETE FROM users_mysmarthome WHERE id = $user_id";

if ($mysqli->query($query_str) === TRUE) {
    echo "User deleted successfully.";
} else {
    echo "Error: " . $mysqli->error;
}

$mysqli->close();
?>

