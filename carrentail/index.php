<?php
session_start(); // Initialize session

require_once 'db_connect.php'; // Database connection

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute the query to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM Customers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if the password is correct
        if (password_verify($password, $user['password'])) {
            // Successful login: Set session variables
            $_SESSION['user_id'] = $user['customer_id']; // Store user ID in session
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Car Rental</title>
    <link rel="stylesheet" href="style.css">
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

            <?php if ($success_message): ?>
                <div class="success" style="color: green; margin-bottom: 10px;">
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <div class="error" style="color: red; margin-bottom: 10px;">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <form action="index.php" method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" class="login-btn" value="Login">
            </form>

            <button class="create-account-btn" onclick="window.location.href='register.php';">Register</button>
        </div>
    </div>
</body>
</html>