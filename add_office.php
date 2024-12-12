<?php
session_start(); // Initialize session

// Ensure the user is logged in as admin
if (!isset($_SESSION['admin_id'])) {
    // Redirect to login page if not an admin
    header("Location: admin_login.php");
    exit();
}

// Include database connection
require_once 'db_connect.php'; // Ensure this file contains the correct database connection

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input
    $office_name = trim($_POST['office_name']);
    $location = trim($_POST['location']);
    $phone_number = trim($_POST['phone_number']);
    $email = trim($_POST['email']);

    // Validation flags
    $valid = true;

    // Validate office_name
    if (empty($office_name)) {
        $_SESSION['error_message'] = "Office name is required.";
        $valid = false;
    }

    // Validate location
    if (empty($location)) {
        $_SESSION['error_message'] = "Location is required.";
        $valid = false;
    }

    // Validate phone number (only digits)
    if (!preg_match('/^\d+$/', $phone_number)) {
        $_SESSION['error_message'] = "Phone number must contain only digits.";
        $valid = false;
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Invalid email format.";
        $valid = false;
    }

    // Check if office with the same name exists in the same location
    if ($valid) {
        $check_query = "SELECT * FROM Offices WHERE office_name = ? AND location = ?";
        $check_stmt = $conn->prepare($check_query);
        if ($check_stmt) {
            $check_stmt->bind_param("ss", $office_name, $location);
            $check_stmt->execute();
            $result = $check_stmt->get_result();
            if ($result->num_rows > 0) {
                $_SESSION['error_message'] = "Office with this name already exists in $location.";
                $valid = false;
            }
            $check_stmt->close();
        } else {
            $_SESSION['error_message'] = "Database error: " . $conn->error;
            $valid = false;
        }
    }

    // Proceed to insert if all validations pass
    if ($valid) {
        $query = "INSERT INTO Offices (office_name, location, phone_number, email) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        if ($stmt) {
            $stmt->bind_param("ssss", $office_name, $location, $phone_number, $email);
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Office added successfully.";
                header("Location: admin_dashboard.php"); // Redirect on success
                exit();
            } else {
                $_SESSION['error_message'] = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $_SESSION['error_message'] = "Database error: " . $conn->error;
        }
    }

    header("Location: add_office.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Office - Car Rental</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Existing styles preserved */
        .btn {
            display: inline-block;
            background-color: #1879CA;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
            margin-top: 15px;
            width: 100%;
            max-width: 300px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn:hover {
            background-color: rgb(236, 236, 236);
            color: #1879CA;
        }

        .btn:focus {
            background-color: rgba(203, 203, 203, 0.6);
        }

        input[type="text"], input[type="email"], select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 20px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="logout.php">↩ logout</a></li>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
        </ul>
        <div class="logo">
            <a href="index.php"><img src="images/logo.png" alt="Logo"></a>
        </div>
    </nav>

    <div class="hero">
        <div class="login">
            <h2>Add Office</h2>

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

            <form action="add_office.php" method="POST">
                <input type="text" name="office_name" placeholder="Office Name" required>
                <select name="location" required>
                    <option value="" disabled selected>Select Location</option>
                    <option value="Alexandria">Alexandria</option>
                    <option value="Cairo">Cairo</option>
                    <option value="Giza">Giza</option>
                </select>
                <input type="text" name="phone_number" placeholder="Phone Number" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="submit" class="btn" value="Add Office">
            </form>

            <form action="admin_dashboard.php" method="GET">
                <input type="submit" class="btn" value="Back to Dashboard">
            </form>
        </div>
    </div>
</body>
</html>
