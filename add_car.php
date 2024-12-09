<?php
session_start(); // Initialize session

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
    <title>Add Car - Car Rental</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* General button style */
        .btn {
            display: inline-block;
            background-color: #1879CA; /* Primary color */
            color: white; /* White text */
            padding: 10px 20px; /* Padding for oval shape */
            border: none;
            border-radius: 20px; /* Fully rounded corners for oval shape */
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            text-decoration: none; /* Remove underline from links */
            transition: background-color 0.3s, color 0.3s;
            margin-top: 15px; /* Adds space between the button and the form */
            width: 100%; /* Makes the button the same width as input fields */
            max-width: 300px; /* Limits the width to match input fields */
            margin-left: auto; /* Centers the button */
            margin-right: auto; /* Centers the button */
        }

        .btn:hover {
            background-color: rgb(236, 236, 236); /* Hover background color */
            color: #1879CA; /* Hover text color */
        }

        .btn:focus {
            background-color: rgba(203, 203, 203, 0.6); /* Focus background color */
        }

        /* Style for input fields and the location dropdown */
        input[type="text"], input[type="number"], input[type="email"], select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 20px; /* Fully rounded corners for oval shape */
            border: 1px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;
        }

        /* Style for the location dropdown */
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 20px; /* Oval shape for select dropdown */
            border: 1px solid #ccc;
            font-size: 16px;
            background-color: #fff;
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
            <h2>Add Car</h2>

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

            <!-- Add Car Form -->
            <form action="add_car_action.php" method="POST">

                <label for="model">Car Model:</label>
                <input type="text" id="model" name="model" required>

                <label for="year">Year:</label>
                <input type="number" id="year" name="year" required>

                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="active">Active</option>
                    <option value="out of service">Out of Service</option>
                    <option value="rented">Rented</option>
                </select>

                <label for="price_per_day">Price per Day:</label>
                <input type="number" id="price_per_day" name="price_per_day" step="10" required>

                <label for="office_id">Office Location:</label>
                <select id="office_id" name="office_id" required>
                    <option value="1">Alexandria</option>
                    <option value="2">Giza</option>
                    <option value="3">Cairo</option>
                </select>

                <input type="submit" class="btn" value="Add Car">
            </form>

            <!-- Back to Admin Dashboard -->
            <form action="admin_dashboard.php" method="GET">
                <input type="submit" class="btn" value="Back to Dashboard">
            </form>

        </div>
    </div>
</body>
</html>
