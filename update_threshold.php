<?php
include("connection.php");

// Få det nya tröskelvärdet från POST-förfrågan
$data = json_decode(file_get_contents("php://input"), true);
$threshold = $data['threshold'];

// Uppdatera tröskelvärdet i databasen
$stmt = $con->prepare("UPDATE sensor_settings SET threshold = ? WHERE sensor_name = 'photoresistor'");
$stmt->bind_param("i", $threshold);

if ($stmt->execute()) {
    echo "Threshold updated successfully.";
} else {
    echo "Error: " . $con->error;
}

$stmt->close();
$con->close();
?>
