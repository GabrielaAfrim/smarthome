<?php
session_start();

// Include database connection file
include("connection.php");

// Check if the login form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    // Prepare and execute SQL statement to retrieve user data based on the username
    $stmt = $con->prepare("SELECT * FROM users_mysmarthome WHERE user_name = ?");
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows == 1) {
        // Fetch user data from the result set
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
        $role = $row['role']; // Retrieve the user's role

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set session variables and redirect based on role
            $_SESSION['user_name'] = $user_name;
            $_SESSION['role'] = $role;

            if ($role == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: menu2.php");
            }
            exit;
        } else {
            // Password is incorrect
            echo "<script>alert('Invalid username or password.');</script>";
        }
    } else {
        // User does not exist
        echo "<script>alert('Invalid username or password.');</script>";
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
    <title>Login</title>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('smart-home-system-guide.jpeg');
            background-size: cover; 
            background-position: center;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #loginBox {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        #loginBox form {
            display: flex;
            flex-direction: column;
        }

        #loginBox input[type="text"],
        #loginBox input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        #loginBox input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #loginBox input[type="submit"]:hover {
            background-color: #0056b3;
        }

        #loginBox a {
            color: #007bff;
            text-decoration: none;
            margin-top: 10px;
            display: inline-block;
        }

        #loginBox a:hover {
            text-decoration: underline;
        }

        #loginBox div {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div id="loginBox">
        <form method="post" action="login.php" autocomplete="off">
            <div>Login to My Smart Home</div>
            <!-- Hidden fields to trick browser autocomplete -->
            <input type="text" style="display:none;">
            <input type="password" style="display:none;">
            
            <input id="text" type="text" name="user_name" placeholder="Username" autocomplete="new-password"><br>
            <input id="text" type="password" name="password" placeholder="Password" autocomplete="new-password"><br>
            <input id="button" type="submit" value="Login"><br>
            <a href="signup.php">Signup</a>
        </form>
    </div>
</body>
</html>


