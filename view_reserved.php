<?php
session_start();
require_once 'db_connect.php';

// Redirect to login if the user is not logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['customer_id'];

// Query to get reserved cars for the logged-in user
$query = "SELECT r.reservation_id, c.model, c.year, r.start_date, r.end_date, r.total_price 
          FROM Reservations r
          JOIN Cars c ON r.car_id = c.car_id
          WHERE r.customer_id = ? AND r.reservation_status = 'rented'";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$reserved_cars = [];
while ($row = $result->fetch_assoc()) {
    $reserved_cars[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reserved Cars - Car Rental</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="user_home.php">Home</a></li>
            <li><a href="reserve.php">Reserve</a></li>
            <li><a href="view_reserved.php">View Reserved Cars</a></li>
        </ul>
        <div class="logo">
            <a href="user_home.php"><img src="images/logo.png" alt="Logo"></a>
        </div>
    </nav>

    <div class="hero">
        <div class="login">
            <h2>Your Reserved Cars:</h2>
            
            <?php if (!empty($reserved_cars)): ?>
                <?php foreach ($reserved_cars as $car): ?>
                    <p><strong>Model:</strong> <?php echo htmlspecialchars($car['model']); ?></p>
                    <p><strong>Year:</strong> <?php echo htmlspecialchars($car['year']); ?></p>
                    <p><strong>Reservation Dates:</strong> <?php echo htmlspecialchars($car['start_date']); ?> to <?php echo htmlspecialchars($car['end_date']); ?></p>
                    <p><strong>Total Price:</strong> <?php echo htmlspecialchars($car['total_price']); ?> LE</p>
                    <hr>
                <?php endforeach; ?>
            <?php else: ?>
                <p>You have not reserved any cars yet.</p>
            <?php endif; ?>

            <!-- Back to Dashboard button -->
            <button class="btn" onclick="window.location.href='user_home.php';">Back to Dashboard</button>
        </div>
    </div>
</body>
</html>