<?php
session_start();
require_once 'db_connect.php';

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$first_name = $_SESSION['first_name'] ?? ''; // We saved the first name during login

// Navbar Link Logic
$homeLink = isset($_SESSION['user_id']) ? "user_home.php" : "index.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home - Car Rental</title>
    <link rel="stylesheet" href="style.css">
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

            <button class="btn" onclick="window.location.href='logout.php';">Logout</button>
            <button class="btn" onclick="window.location.href='view_reserved.php';">View Reserved Cars</button>
            <button class="btn" onclick="window.location.href='reserve.php';">Reserve a Car</button>
        </div>
    </div>
</body>
</html>
