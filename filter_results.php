<?php
session_start();

require_once 'db_connect.php';
include 'navbar.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch filter values from GET parameters
$price_range = isset($_GET['price_range']) ? $_GET['price_range'] : '';
$car_location = isset($_GET['car-location']) ? $_GET['car-location'] : '';
$car_year = isset($_GET['car-year']) ? $_GET['car-year'] : '';
$car_status = isset($_GET['car-status']) ? $_GET['car-status'] : '';

// Base SQL query
$sql = "SELECT * FROM cars JOIN offices ON offices.office_id = cars.office_id WHERE 1=1";

// Apply filters
if (!empty($price_range)) {
    if ($price_range == 'low') {
        $sql .= " AND price_per_day BETWEEN 1000 AND 2000";
    } elseif ($price_range == 'medium') {
        $sql .= " AND price_per_day BETWEEN 2000 AND 3000";
    } elseif ($price_range == 'high') {
        $sql .= " AND price_per_day > 3000";
    }
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
</head>
<body>


    <h1>Reserve Your Dream Car</h1>

    <section class="car-section">
    <?php 
    include 'sidebar.php';
    ?>

        <div class="car-container">
            <?php if (count($cars) > 0): ?>
                <?php foreach ($cars as $car): ?>
                    <div class="car-card">
                        <img src="images/cars/<?php echo htmlspecialchars($car['image']); ?>" alt="Car Image">
                        <div class="description">
                            <h2><?php echo htmlspecialchars($car['model']); ?></h2>
                            <h4>Office Name: <?php echo htmlspecialchars($car['office_name']); ?></h4>
                            <h5>Location: <?php echo htmlspecialchars($car['location']); ?></h5>
                            <p>Price: <?php echo round(htmlspecialchars($car['price_per_day']), 1); ?> LE</p>
                            <p>Model: <?php echo htmlspecialchars($car['year']); ?></p>
                            <span style="<?php echo $car['status'] === 'active' ? 'color: green;' : ($car['status'] === 'rented' ? 'color: red;' : 'color: yellow;'); ?>">
                                <?php echo ucfirst(htmlspecialchars($car['status'])); ?>
                            </span>
                        </div>
                        <form action="reserve.php" method="POST">
                            <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($car['car_id']); ?>">
                            <button class="reserve-btn" type="submit">Reserve Now</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No cars found matching the filter criteria.</p>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>
