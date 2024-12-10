<?php
session_start();

require_once 'db_connect.php';
include 'navbar.php';
include 'generate_car.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch filter values from GET parameters
$car_location = isset($_GET['car-location']) ? $_GET['car-location'] : '';
$car_year = isset($_GET['car-year']) ? $_GET['car-year'] : '';
$car_status = isset($_GET['car-status']) ? $_GET['car-status'] : '';
$min_price = isset($_GET['min_price']) ? $_GET['min_price'] : '';
$max_price = isset($_GET['max_price']) ? $_GET['max_price'] : '';

$sql = "SELECT * FROM cars JOIN offices ON offices.office_id = cars.office_id WHERE 1=1";

// Apply filters
if (!empty($min_price)) {
    $sql .= " AND cars.price_per_day BETWEEN $min_price AND  $max_price";
}

if (!empty($car_location)) {
    $sql .= " AND offices.location = '" . $conn->real_escape_string($car_location) . "'";
}

if (!empty($car_year)) {
    $sql .= " AND cars.year = " . intval($car_year);
}

if (!empty($car_status)) {
    $sql .= " AND cars.status = '" . $conn->real_escape_string($car_status) . "'";
}

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
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
    <script src="script.js"></script>

    
</head>
<body>


    <h1>Reserve Your Dream Car</h1>

    <section class="car-section">
        <?php 
        include 'sidebar.php';
        echo renderCarContainerFilter($cars);
        ?>
        
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
    <script src="script.js"></script>
</body>
</html>
