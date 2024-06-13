<?php
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit;
}

$user_name = $_SESSION['user_name'];
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

// Include database connection file
include("connection.php");

// Delete user functionality
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
    $user_to_delete = $_POST['delete_user'];

    // Prevent deleting the admin account
    if ($user_to_delete != 'admin') {
        // Prepare and execute SQL statement to delete user
        $stmt = $con->prepare("DELETE FROM users_mysmarthome WHERE user_name = ?");
        $stmt->bind_param("s", $user_to_delete);
        $stmt->execute();
        $stmt->close();

        echo "<script>alert('User $user_to_delete has been deleted.');</script>";
    } else {
        echo "<script>alert('You cannot delete the admin account.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Smart Home</title>
    <link rel="stylesheet" href="mystyle2.css">
    <style>
        
        /* Reset styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header styles */
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px 0;
        }

        .logo {
            margin: 0;
            font-size: 24px;
        }

        .user-info {
            text-align: right;
        }

        .welcome {
            display: inline-block;
            margin-right: 10px;
        }

        .logout-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        /* Main styles */
        .main {
            padding: 20px;
        }

        .section-title {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .light-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .light-btn {
            flex: 0 0 calc(33.33% - 10px);
            margin-bottom: 10px;
            padding: 20px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .light-btn:hover {
            opacity: 0.8;
        }

        .light-btn.green {
            background-color: #28a745;
            color: white;
        }

        .light-btn.white {
            background-color: white;
            color: #007bff;
        }

        .light-btn.blue {
            background-color: #007bff;
            color: white;
        }

        .light-btn.yellow {
            background-color: #ffc107;
            color: white;
        }

        .light-btn.purple {
            background-color: #6f42c1;
            color: white;
        }

        .light-btn.off {
            background-color: #dc3545;
            color: white;
        }

        .light-btn.stop-motion {
            background-color: #343a40;
            color: white;
        }

        /* Table styles */
        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .user-table th,
        .user-table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .user-table th {
            background-color: #007bff;
            color: white;
        }

        /* Footer styles */
        .footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

    </style>
    <script>
        function updateConnectionStatus(isConnected) {
            const statusElement = document.getElementById('connectionStatus');
            if (isConnected) {
                statusElement.textContent = 'Device is connected';
                statusElement.style.color = 'green';
            } else {
                statusElement.textContent = 'Device is not connected';
                statusElement.style.color = 'red';
            }
        }

        // Gör en AJAX-förfrågan till servern för att kontrollera anslutningsstatus
        function checkConnection() {
            fetch('check_connection.php')
                .then(response => response.json())
                .then(data => {
                    updateConnectionStatus(data.isConnected);
                });
        }

        // Kontrollera anslutningsstatus när sidan laddas
        window.onload = checkConnection;
        function toggleLight(state) {
            const userName = '<?php echo $user_name; ?>';
            fetch(`toggle_light.php?state=${state}&user_name=${userName}`)
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                });
        }
        function confirmDelete(user) {
            if (confirm("Are you sure you want to delete the user '" + user + "'?")) {
                document.getElementById("deleteForm_" + user).submit();
            }
        }
    </script>
</head>
<body>
    <header class="header">
        <div class="container">
            <h1 class="logo">My Smart Home</h1>
            <div class="user-info">
                <p class="welcome">Hi, <?php echo $user_name; ?>!</p>
                <a href="login.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </header>
    <main class="main">
        <div class="container">
            <section class="control-lights">
                <h2 class="section-title">Control Lights</h2>
                <div class="light-buttons">
                    <button class="light-btn green" onclick="toggleLight('on')">Turn Green light on</button>
                    <button class="light-btn white" onclick="toggleLight('white')">Turn White ligh on</button>
                    <button class="light-btn blue" onclick="toggleLight('blue')">Turn Blue ligh on</button>
                    <button class="light-btn yellow" onclick="toggleLight('yellow')">Turn Yellow ligh on</button>
                    <button class="light-btn purple" onclick="toggleLight('purple')">Turn Purple light on</button>
                    <button class="light-btn off" onclick="toggleLight('off')">Turn Light Off</button>
                    <button class="light-btn stop-motion" onclick="toggleLight('stop_motion')">Stop Motion Light</button>
                </div>
            </section>
            <section class="latest-movement">
                <h2 class="section-title">Latest Movement</h2>
                <?php include 'display-movement-status.php'; ?>

                
                <div id="connectionStatus"></div>
                </div>
            </section>
            <?php if ($role == 'admin'): ?>
                <section class="all-users">
                    <h2 class="section-title">All Users</h2>
                    <div class="user-list">
                        <table class="user-table">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = $con->query("SELECT user_name FROM users_mysmarthome WHERE role != 'admin'");
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['user_name']) . "</td>";
                                    echo "<td>";
                                    if ($row['user_name'] != $user_name) { // Prevent admin from deleting themselves
                                        echo "<form method='post' action='menu2.php' class='delete-form'>";
                                        echo "<input type='hidden' name='delete_user' value='" . htmlspecialchars($row['user_name']) . "'>";
                                        echo "<button type='button' class='delete-btn' onclick='confirmDelete(\"" . htmlspecialchars($row['user_name']) . "\")'>Delete</button>";
                                        echo "</form>";
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                $result->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    </main>
    <footer class="footer">
        <p>&copy; Webbsystem Course, 2024</p>
    </footer>
</body>
</html>

























