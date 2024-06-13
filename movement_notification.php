<?php
if (isset($_GET['status'])) {
    $status = $_GET['status'];
    $movement = $status == 'detected' ? 1 : 0;

    $mysqli = new mysqli("127.0.0.1", "GA", "1550gaboshe", "database_webpage");

    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }

    $query_str = "UPDATE movement_status SET detected = $movement WHERE id = 1";
    $mysqli->query($query_str);
    $mysqli->close();
    echo "Movement status updated.";
} else {
    echo "Invalid parameters!";
}
?>
