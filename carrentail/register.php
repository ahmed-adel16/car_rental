<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$dbname = "CarRentalSystem"; // The name of your database

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Registration logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];
    
    // Server-side validation for phone number
    if (!is_numeric($phone_number)) {
        $_SESSION['error_message'] = "Phone number should only contain numbers.";
        header("Location: register.php");
        exit();
    }

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into the Customers table
    $sql = "INSERT INTO Customers (first_name, last_name, email, phone_number, password) 
            VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        // Registration successful, set success message and redirect to index.php
        $_SESSION['success_message'] = "Registration successful! Please log in.";
        header("Location: index.php");
        exit();
    } else {
        // Handle error
        $_SESSION['error_message'] = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Car Rental</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="reserve.php">Reserve</a></li> <!-- Updated link -->
        </ul>
        <div class="logo">
            <a href="index.php"><img src="images/logo.png" alt="Logo"></a>
        </div>
    </nav>

    <div class="hero">
        <div class="login">
            <h2>Register</h2>

            <!-- Display error message if it exists -->
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="error" style="color: red; margin-bottom: 10px;">
                    <?php echo htmlspecialchars($_SESSION['error_message']); ?>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            <!-- Display success message if it exists -->
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="success" style="color: green; margin-bottom: 10px;">
                    <?php echo htmlspecialchars($_SESSION['success_message']); ?>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <!-- Registration Form -->
            <form action="register.php" method="POST">
                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="phone_number" placeholder="Phone Number" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" class="btn" value="Register">
            </form>

            <!-- Link back to the login page -->
            <button class="btn" onclick="window.location.href='index.php';">Back to Login</button>
        </div>
    </div>
</body>
</html>
