<?php
session_start();

require_once 'db_connect.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: index.php");
    exit();
}

// Placeholder logic for reservation (adjust as needed)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process reservation here (e.g., save the car reservation to the database)
    $_SESSION['success_message'] = "Reservation successful!";
    header("Location: reserve.php");
    exit();
}

$sql = 'SELECT * FROM cars JOIN offices ON offices.office_id = cars.office_id';
$result = $conn -> query($sql);

if (!$result) {
    die('Query faild'. $conn-> error);
}

$cars = [];

while ($row = $result -> fetch_assoc()){
    $cars[] = $row;
}


function renderCarCards($cars) {
    $output = '<div class="car-container">';
    foreach ($cars as $car) {
        $card_color = '';
        if ($car['status'] === 'active') {
            $card_color = 'color: green;';
        } elseif ($car['status'] === 'rented') {
            $card_color = 'color: red;';
        } elseif ($car['status'] === 'out of service') {
            $card_color = 'color: yellow;';
        }
        
        $output .= '
        <div class="car-card">
            <img src="images/cars/' . htmlspecialchars($car['image']) . '">
            <div class="description">
                <h2 class="car-model">' . htmlspecialchars($car['model']) . '</h2>
                <h4 class="office-name" style="color: #eee;">Office Name: ' . htmlspecialchars($car['office_name']) . '</h4>
                <h5 class="office-location" style="color: #eee;">Location: ' . htmlspecialchars($car['location']) . '</h5>
                <p class="car-price">Price: ' . round(htmlspecialchars($car['price_per_day']), 1) . ' LE</p>
                <p class="car-year">Model: ' . htmlspecialchars($car['year']) . '</p>
                <span class="car-status" style="' . $card_color . '">' . ucfirst(htmlspecialchars($car['status'])) . '</span>
            </div>
            <form action="reserve.php" method="POST">
                <input type="hidden" name="car_id" value="' . htmlspecialchars($car['car_id']) . '">
                <button class="reserve-btn" type="submit">Reserve Now</button>
            </form>
        </div>';
    }
    $output .= '</div>';
    return $output;
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
    <nav class="navbar">
        <ul>
            <!-- Change Home link to user_home.php -->
            <li><a href="logout.php">↩ Log out</a></li>
        </ul>
        <div class="logo">
            <a href="user_home.php"><img src="images/logo.png" alt="Car Rental Logo"></a>
        </div>
    </nav>

    
    <h1>Reserve Your Dream Car</h1>

    <section class="car-section">
        
    <?php 
    include 'sidebar.php';
    ?>

        <div class="car-container">
            <?php echo renderCarCards($cars); ?>
        </div>
    </section>
</body>
</html>
