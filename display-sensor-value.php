<?php
$mysqli = new mysqli("127.0.0.1", "GA", "1550gaboshe", "database_webpage");

// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// Construct the SQL query string to select the latest sensor value
$query_str = "SELECT * FROM sensors ORDER BY id DESC LIMIT 1";

// Execute the query
$result = $mysqli->query($query_str);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Fetch the sensor value from the result set
    $row = $result->fetch_assoc();
    $sensor_value = $row['value'];

    // Display the sensor value
    echo "<div id='sensor_value'>Latest sensor value: " . $sensor_value . "</div>";
} else {
    // No sensor value found
    echo "No sensor value available";
}

// Close the database connection
$mysqli->close();
?>

