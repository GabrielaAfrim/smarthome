<?php
$mysqli = new mysqli("127.0.0.1", "GA", "1550gaboshe", "database_webpage");

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

if (isset($_GET['state'])) {
    $state = $_GET['state'];
    if ($state === 'on' || $state === 'off') {
        $stmt = $mysqli->prepare("INSERT INTO light_control (state) VALUES (?)");
        $stmt->bind_param("s", $state);
        if ($stmt->execute()) {
            echo "Light command updated successfully.";
        } else {
            echo "Failed to update light command.";
        }
        $stmt->close();
    } else {
        echo "Invalid command.";
    }
} else {
    echo "No command provided.";
}

$mysqli->close();
?>

