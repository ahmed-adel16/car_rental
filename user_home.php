<?php
session_start();
require_once 'db_connect.php';

// Redirect to login if the user is not logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['customer_id'];
$first_name = $_SESSION['first_name'] ?? ''; // We saved the first name during login

// Navbar Link Logic
$homeLink = isset($_SESSION['customer_id']) ? "user_home.php" : "index.php";

// Check for success message
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']); // Clear the message after displaying
} else {
    $success_message = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home - Car Rental</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Success message styling */
        .success-message {
            background-color: #4CAF50;
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
            <li><a href="<?php echo $homeLink; ?>">Home</a></li>
            <li><a href="reserve.php">Reserve</a></li>
            <li><a href="view_reserved.php">View Reserved Cars</a></li>
        </ul>
        <div class="logo">
            <a href="<?php echo $homeLink; ?>"><img src="images/logo.png" alt="Logo"></a>
        </div>
    </nav>

    <div class="hero">
        <div class="login">
            <h2>Welcome, <?php echo htmlspecialchars($first_name); ?>!</h2>

            <!-- Display success message if existss -->
            <?php if ($success_message): ?>
                <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif; ?>

            <button class="btn" onclick="window.location.href='logout.php';">Logout</button>
            <button class="btn" onclick="window.location.href='view_reserved.php';">View Reserved Cars</button>
            <button class="btn" onclick="window.location.href='reserve.php';">Reserve a Car</button>
        </div>
    </div>
</body>
</html>