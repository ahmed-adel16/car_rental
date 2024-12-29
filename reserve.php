<?php
session_start();
require_once 'db_connect.php';
include 'generate_car.php';
$current_date = date('Y-m-d');
if (!isset($_SESSION['customer_id'])) {
    header("Location: index.php");
    exit();
}

// Handle reservation submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['car_id'], $_POST['start_date'], $_POST['end_date'])) {
    $car_id = $_POST['car_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Fetch car details including office_id
    $query = "SELECT price_per_day, office_id FROM Cars WHERE car_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $stmt->bind_result($price_per_day, $office_id);
    $stmt->fetch();
    $stmt->close();

    // Calculate the total price
    $start_date_obj = new DateTime($start_date);
    $end_date_obj = new DateTime($end_date);
    $interval = $start_date_obj->diff($end_date_obj);
    $total_days = $interval->days > 0 ? $interval->days : 1; // Minimum 1 day
    $total_price = $total_days * $price_per_day;

    // Insert reservation into the database
    $insert_reservation = $conn->prepare(
        "INSERT INTO Reservations (customer_id, car_id, office_id, start_date, end_date, reservation_status, total_price) 
         VALUES (?, ?, ?, ?, ?, 'upcoming', ?)"
    );
    $insert_reservation->bind_param(
        "iiissd",
        $_SESSION['customer_id'],
        $car_id,
        $office_id,
        $start_date,
        $end_date,
        $total_price
    );
    if ($start_date >= $current_date && $end_date > $start_date)
        $insert_reservation->execute();
    else {
        $_SESSION['error_message'] = "Invalid dates. Please enter valid dates.";
        header("Location: user_home.php");
        exit();
    }


    // Redirect to user_home.php with success message
    $_SESSION['success_message'] = "Car reserved successfully! It will be rented starting from the reservation start date.";
    header("Location: user_home.php");
    exit();
}

// Fetch car details for rendering
$sql = 'SELECT cars.*, offices.office_name, offices.location, offices.office_id 
        FROM cars 
        JOIN offices ON offices.office_id = cars.office_id';
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
    <script src='script.js'></script>
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
                <input type="date" id="start-date" name="start_date" value="<?php echo date('Y-m-d'); ?>" required onchange="calculateTotalPrice()">

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
