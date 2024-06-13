<?php
$mysqli = new mysqli("127.0.0.1", "GA", "1550gaboshe", "database_webpage");

// Kontrollera anslutningen
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// Konstruera SQL-frågan för att uppdatera lampans tillstånd
$query_str = "INSERT INTO light_control (light_id, state) VALUES (1, 'stop_motion')";

// Utför frågan
if ($mysqli->query($query_str) === TRUE) {
    echo "Motion light stopped successfully.";
} else {
    echo "Error: " . $mysqli->error;
}

// Stäng databasanslutningen
$mysqli->close();
?>




