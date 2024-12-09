<?php
session_start(); // Initialize session

require_once 'db_connect.php';
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

                <label for="year">Plate ID:</label>
                <input type="text" id="plate-id" name="plate-id" required>

                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="active">Active</option>
                    <option value="out of service">Out of Service</option>
                    <option value="rented">Rented</option>
                </select>

                <label for="price_per_day">Price per Day:</label>
                <input type="number" id="price_per_day" name="price_per_day" step="10" required>

                <label for="office_name">Office Name:</label>
                <select id="office_name" name="office_name" required>
                    <?php
                        $query = "SELECT office_name FROM offices";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . htmlspecialchars($row['office_name']) . '">' . ucfirst($row['office_name']) . '</option>';
                            }
                        } else {
                            echo '<option value="">No locations available</option>';
                        }

                        $conn->close(); // Close the database connection
                    ?>
                </select>                

                <input type="submit" class="btn" value="Add Car">
            </form>

            <form action="admin_dashboard.php" method="GET">
                <input type="submit" class="btn" value="Back to Dashboard">
            </form>

        </div>
    </div>
</body>
</html>
