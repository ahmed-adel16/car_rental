<?php
session_start(); // Initialize session
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Ensure the user is logged in as admin
if (!isset($_SESSION['admin_id'])) {

    // Redirect to login page if not an admin
    header("Location: admin_login.php");
    exit();
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
    <title>Admin Dashboard - Car Rental</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Remove the underline from the anchor tags */
        a {
            text-decoration: none;
        }

        /* Optional: You can also customize the hover effect if needed */
        a:hover {
            text-decoration: none;
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
            <h2>Welcome, Admin!</h2>

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

            <!-- Add Office Button (Redirects to add_office.php) -->
            <a href="add_office.php">
                <button class="btn login-btn">Add Office</button>
            </a>

            <!-- Add Car Button (Redirects to add_car.php) -->
            <a href="add_car.php">
                <button class="btn login-btn">Add Car</button>
            </a>

            <!-- Logout Button -->
            <form action="logout.php" method="POST">
                <input type="submit" class="btn" value="Logout">
            </form>
        </div>
    </div>
</body>
</html>
