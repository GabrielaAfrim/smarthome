<?php
$mysqli = new mysqli("127.0.0.1", "GA", "1550gaboshe", "database_webpage");

// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// Construct the SQL query string to select the latest movement status
$query_str = "SELECT detected, timestamp FROM movement_status ORDER BY id DESC LIMIT 1";

// Execute the query
$result = $mysqli->query($query_str);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Fetch the movement status from the result set
    $row = $result->fetch_assoc();
    $detected = $row['detected'];
    $timestamp = $row['timestamp'];

    // Display the movement status
    if ($detected) {
        echo "Movement detected at " . $timestamp;
    } else {
        echo "No movement detected. Last checked at " . $timestamp;
    }
} else {
    // No movement status found
    echo "No movement status available";
}

// Close the database connection
$mysqli->close();
?>
