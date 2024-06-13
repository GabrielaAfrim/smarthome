<?php
session_start();

// Include database connection file
include("connection.php");

// Initialize error message variable
$error_message = "";

// Check if the signup form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute SQL statement to insert user data
    $stmt = $con->prepare("INSERT INTO users_mysmarthome (user_name, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $user_name, $hashed_password);

    // Check if the query executed successfully
    if ($stmt->execute()) {
        // Signup successful
        $error_message = "Your account has been successfully created.";
    } else {
        // Signup failed
        $error_message = "Error: " . $con->error;
    }

    // Close statement
    $stmt->close();
}

// Close database connection
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Signup</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="mystyle2.css">
    <style>
        /* Add your CSS styles here */
        #signupBox {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 5px;
            width: 300px;
            margin: 0 auto;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #signupBox div {
            font-size: 20px;
            margin: 10px;
        }

        #signupBox input[type="text"],
        #signupBox input[type="password"],
        #signupBox input[type="submit"],
        #signupBox a {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border: none;
            border-radius: 5px;
        }

        #signupBox input[type="text"],
        #signupBox input[type="password"] {
            box-sizing: border-box;
        }

        #signupBox input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        #signupBox input[type="submit"]:hover {
            background-color: #0056b3;
        }

        #signupBox a {
            text-decoration: none;
            color: #007bff;
        }

        #signupMessage {
            color: #dc3545;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div id="signupBox">
        <form method="post" action="signup.php" autocomplete="off">
            <div>Signup</div>
            <!-- Hidden fields to trick browser autocomplete -->
            <input type="text" style="display:none;">
            <input type="password" style="display:none;">
            
            <input type="text" name="user_name" placeholder="Username" autocomplete="new-password"><br><br>
            <input type="password" name="password" placeholder="Password" autocomplete="new-password"><br><br>
            <input type="submit" value="Signup"><br><br>
            <a href="login.php">Login</a><br><br>
        </form>
        <?php
        // Display error message if it exists
        if (!empty($error_message)) {
            echo "<div id='signupMessage'>$error_message</div>";
        }
        ?>
    </div>
</body>
</html>



