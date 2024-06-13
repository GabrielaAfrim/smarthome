<?php
function checkDeviceConnection($ip, $port = 80, $timeout = 5) {
    $connected = @fsockopen($ip, $port, $errno, $errstr, $timeout);
    if ($connected) {
        fclose($connected);
        return true;
    }
    return false;
    // Logga detaljerad felinformation
    error_log("Connection to $ip failed: $errstr ($errno)");
    return false;
}
// Kontrollera anslutningsstatus för IoT-enheten

$ip = '172.20.10.5'; // IP-adressen till RaspBerryn



// Kontrollera anslutningsstatus
$isDeviceConnected = checkDeviceConnection($ip);

// Returnera resultatet som JSON
echo json_encode(['isConnected' => $isDeviceConnected]);
?>
