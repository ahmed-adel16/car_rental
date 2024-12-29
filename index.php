<?php
session_start(); // Initialize session

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

require_once 'db_connect.php'; // Database connection

if (isset($_SESSION['admin_id'])) {
    header("Location: admin_dashboard.php");
    exit();
}
if (isset($_SESSION['customer_id'])) {
    header("Location: user_home.php");
    exit();
}

function emailExists($email, $conn) {
    $stmt = $conn->prepare('SELECT * FROM Customers WHERE email = ?');
    $stmt -> bind_param('s', $email);
    $stmt -> execute();
    $result = $stmt -> get_result();

    if ($result -> num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Server-side validation for email existence
    if (!emailExists($email, $conn)) {
        $_SESSION['error_message'] = "Invalid email or password.";
        header("Location: index.php");
        exit();
    }

    // Prepare and execute the query to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM Customers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // If a user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if the password is correct
        if (password_verify($password, $user['password'])) {
            // Successful login: Set session variables
            $_SESSION['customer_id'] = $user['customer_id']; // Store user ID in session
            $_SESSION['first_name'] = $user['first_name']; // Store first name in session
            $_SESSION['success_message'] = "Login successful!";

            // Redirect to user_home.php after login
            header("Location: user_home.php");
            exit(); // Ensure no further code executes after redirect
        } else {
            // Incorrect password
            $_SESSION['error_message'] = "Invalid email or password.";
        }
    } else {
        // No user found with that email
        $_SESSION['error_message'] = "Invalid email or password.";
    }

    // Redirect to the same page to show error message
    header("Location: index.php");
    exit(); // Ensure no further code executes after redirect
}

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['success_message']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Car Rental</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .error {
            background-color:rgb(125, 2, 0) ;
            color: white;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
            font-weight: bold;
        }
        .success {
            background-color:rgb(125, 2, 0);
            color: white;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="reserve.php">Reserve</a></li>
        </ul>
        <div class="logo">
            <a href="index.php"><img src="images/logo.png" alt="Logo"></a>
        </div>
    </nav>

    <div class="hero">
        <div class="login">
            <h2>Login</h2>
            <?php if ($error_message): ?>
                <div class="error">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            <form action="index.php" method="POST">
                <input type="email" class = 'email' name="email" placeholder="Email" required>
                <input type="password" class = 'pw' name="password" placeholder="Password" required>
                <button type="submit" class="btn">Login</button>
            </form>

            <button class="btn" onclick="window.location.href='admin_login.php';">Login as Admin</button> 
            <p class= 'hyperlink'>Don't have an account? <a class = 'register-hyperlink' href="register.php">register</a></p>

        </div>
    </div>
</body>
</html>