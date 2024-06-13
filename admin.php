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

// Hämta alla användare
$query_str = "SELECT id, user_name, role FROM users_mysmarthome";
$result = $mysqli->query($query_str);

if ($result->num_rows > 0) {
    echo "<table border='1'>
    <tr>
    <th>ID</th>
    <th>Username</th>
    <th>Role</th>
    <th>Action</th>
    </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['user_name'] . "</td>";
        echo "<td>" . $row['role'] . "</td>";
        echo "<td><button onclick=\"deleteUser(" . $row['id'] . ")\">Delete</button></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No users found.";
}

$mysqli->close();
?>

<script>
function deleteUser(userId) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            alert(this.responseText);
            location.reload();
        }
    };
    xmlhttp.open("GET", "delete_user.php?id=" + userId, true);
    xmlhttp.send();
}
</script>

