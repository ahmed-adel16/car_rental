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
    <link rel="stylesheet" href="cards.css">
    <style>
        /* Remove the underline from the anchor tags */
        a {
            text-decoration: none;
        }

        /* Optional: You can also customize the hover effect if needed */
        a:hover {
            text-decoration: none;
        }
        /* Success message styling */
        .success-message {
            background-color: #4CAF50;
            color: white;
            flex:1 100%;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
            font-weight: bold;
        }
        .error-message {
            background-color:rgb(125, 2, 0) ;
            flex:1 100%;
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
            <h2 class = 'header'>Welcome, Admin!</h2>

            <!-- Display success message if existss -->
            <?php if ($success_message): ?>
                <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif; ?>
            <?php if ($error_message): ?>
                <div class="error-message"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif; ?>

            <!-- Add Office Button (Redirects to add_office.php) -->
            <div class="function-card">
            <a href="add_office.php">
                <button class=" login-btn">Add Office</button>
            </a>
            </div>

            <div class="function-card">
            <a href="manage_reservations.php">
                <button class=" login-btn">Manage Reservations</button>
            </a>
            </div>

            <div class="function-card">
            <a href="car_report.php">
                <button class=" login-btn">Car Report</button>
            </a>
            </div>

            <div class="function-card">
            <a href="daily_payment_report.php">
                <button class = " login-btn">Daily Payment Report</button>
            </a>
            </div>

            <!-- Add Car Button (Redirects to add_car.php) -->
            <div class="function-card">
                <a href="add_car.php">
                    <button class=" login-btn">Add Car</button>
                </a>
            </div>

            <!-- Logout Button -->
            <form action="logout.php" method="POST">
                <div class = 'function-card'>
                    <input type="submit" class="btn logout-btn" value="Logout">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
