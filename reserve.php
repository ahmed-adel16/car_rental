<?php
session_start();
require_once 'db_connect.php';
include 'generate_car.php';
if (!isset($_SESSION['customer_id'])) {
    header("Location: index.php");
    exit();
}

// Handle reservation submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['car_id'], $_POST['start_date'], $_POST['end_date'])) {
    $car_id = $_POST['car_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Calculate the total price
    $query = "SELECT price_per_day FROM Cars WHERE car_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $stmt->bind_result($price_per_day);
    $stmt->fetch();
    $stmt->close();

    // Calculate the total price without validation for duration
    $start_date_obj = new DateTime($start_date);
    $end_date_obj = new DateTime($end_date);
    $interval = $start_date_obj->diff($end_date_obj);
    $total_days = $interval->days > 0 ? $interval->days : 1; // Minimum 1 day
    $total_price = $total_days * $price_per_day;

    // Insert reservation into the database
    $insert_reservation = $conn->prepare("INSERT INTO Reservations (customer_id, car_id, start_date, end_date, reservation_status, total_price) VALUES (?, ?, ?, ?, 'rented', ?)");
    $insert_reservation->bind_param("iissd", $_SESSION['customer_id'], $car_id, $start_date, $end_date, $total_price);
    $insert_reservation->execute();

    // Update car status to rented
    $update_car_status = $conn->prepare("UPDATE Cars SET status = 'rented' WHERE car_id = ?");
    $update_car_status->bind_param("i", $car_id);
    $update_car_status->execute();

    // Redirect to user_home.php with success message
    $_SESSION['success_message'] = "Car reserved successfully!";
    header("Location: user_home.php");
    exit();
}

$sql = 'SELECT * FROM cars JOIN offices ON offices.office_id = cars.office_id';
$result = $conn->query($sql);

if (!$result) {
    die('Query failed: ' . $conn->error);
}

$cars = [];

while ($row = $result->fetch_assoc()) {
    $cars[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve Your Car</title>
    <link rel="stylesheet" href="reserve.css">
    <link rel="stylesheet" href="modal.css">
    <script src = 'script.js'></script>
    
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="logout.php">↩ Log out</a></li>
        </ul>
        <div class="logo">
            <a href="user_home.php"><img src="images/logo.png" alt="Car Rental Logo"></a>
        </div>
    </nav>

    <h1>Reserve Your Dream Car</h1>

    <section class="car-section">
        <?php include 'sidebar.php'; ?>

        <div class="car-container">
            <?php echo renderCarCards($cars); ?>
        </div>
    </section>

    <!-- Reservation Modal -->
    <div id="reservation-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeReservationModal()">&times;</span>
            <h2>Enter Reservation Details</h2>
            <form action="reserve.php" method="POST">
                <input type="hidden" name="car_id" id="car-id">
                <input type="hidden" name="price_per_day" id="price-per-day">

                <!-- Start Date Label and Input -->
                <label for="start-date">Start Date:</label>
                <input type="date" id="start-date" name="start_date" required onchange="calculateTotalPrice()">

                <!-- End Date Label and Input -->
                <label for="end-date">End Date:</label>
                <input type="date" id="end-date" name="end_date" required onchange="calculateTotalPrice()">

                <!-- Display Total Price -->
                <p id="total-price">Total Price: 0.00 LE</p>
                <input type="hidden" name="total_price" id="total-price-input">

                <button type="submit" class="btn">Reserve Now</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 CarRentalSystem</p>
    </footer>
</body>
</html>
