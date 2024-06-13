<?php
// toggle_light.php
$host = "127.0.0.1";
$username = "Gabriela";
$password = "1550gaboshe";
$database = "database_webpage";

// Create connection
$con = new mysqli($host, $username, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if (isset($_GET['state']) && isset($_GET['user_name'])) {
    $state = $_GET['state'];
    $user_name = $_GET['user_name'];

    $stmt = $con->prepare("INSERT INTO light_control (state, user_name) VALUES (?, ?)");
    $stmt->bind_param("ss", $state, $user_name);

    if ($stmt->execute()) {
        echo "Light state updated to '$state' by '$user_name'";
    } else {
        echo "Error updating light state: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request";
}

$con->close();
?>



