<?php
session_start(); // Initialize session
require_once 'db_connect.php'; // Database connection

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");


if (isset($_SESSION['admin_id'])) {
    header("Location: admin_dashboard.php");
    exit();
}
if (isset($_SESSION['customer_id'])) {
    header("Location: user_home.php");
    exit();
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute the query to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");

    // Check if the preparation fails
    if ($stmt === false) {
        die('Error preparing the SQL query: ' . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // If an admin exists
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Check if the password matches (without hashing)
        if (password_verify($password, $admin['password'])) {
            // Successful login: Set session variables
            $_SESSION['admin_id'] = $admin['admin_id']; // Store admin ID in session
            $_SESSION['first_name'] = $admin['first_name']; // Store first name in session
            $_SESSION['success_message'] = "Login successful!";

            // Redirect to admin dashboard after login
            header("Location: admin_dashboard.php");
            exit(); // Ensure no further code executes after redirect
        } else {
            // Incorrect password
            $_SESSION['error_message'] = "Invalid email or password.";
        }
    } else {
        // No admin found with that email
        $_SESSION['error_message'] = "Invalid email or password.";
    }

    // Redirect to the same page to show error message
    header("Location: admin_login.php");
    exit(); // Ensure no further code executes after redirect
}

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Car Rental</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .success-message {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
            font-weight: bold;
        }
        .error-message {
            background-color:rgb(125, 2, 0) ;
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
        </ul>
        <div class="logo">
            <a href="index.php"><img src="images/logo.png" alt="Logo"></a>
        </div>
    </nav>

    <div class="hero">
        <div class="login">
            <h2>Admin Login</h2>

            <?php if ($success_message): ?>
                <div class="success-message">
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <form action="admin_login.php" method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="btn login-btn" >Login</button>
            </form>

            <button class="btn" onclick="window.location.href='index.php';">Go Back</button>
        </div>
    </div>
</body>
</html>
