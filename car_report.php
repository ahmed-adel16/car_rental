<?php
session_start();
require_once 'db_connect.php';

$selected_date = $_GET['report-day'] ?? null;
$car_status_data = [];
$current_date = date('Y-m-d'); // Get current date

if ($selected_date) {
    // Query to fetch car statuses for the selected date
    $query = "
        SELECT cars.car_id, cars.model, cars.status AS car_status, reservations.start_date, reservations.end_date
        FROM Cars cars
        LEFT JOIN Reservations reservations 
        ON cars.car_id = reservations.car_id";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $stmt->bind_result($car_id, $car_model, $car_status, $start_date, $end_date);

    // Fetch car statuses for the selected date
    while ($stmt->fetch()) {
        // Check if there's a reservation and its dates
        if ($start_date <= $selected_date && $selected_date <= $end_date) {
            $status = 'rented'; // Car is rented for the selected date
        } elseif ($start_date > $selected_date) {
            $status = 'upcoming'; // Reservation is upcoming
        } elseif ($selected_date > $end_date) {
            $status = 'active'; // Reservation has ended
        } else {
            $status = $car_status; // If no reservation or reservation has ended, check car's current status
        }

        // Store the car status data
        $car_status_data[] = ['car_id' => $car_id, 'status' => $status, 'model' => $car_model];
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Car Rental</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="cards.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: left;
            color: white;
        }
        th, td {
            padding: 12px;
            border: 1px solid white;
        }
        th {
            background-color: rgb(35, 35, 35);
        }
        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .no-data {
            display:block;
            text-align: center;
            font-size: 20px;
            color: red;
        }

        .report-day {
            display :inline !important;
            width: 150px !important;
            margin-left: 30px;
        }
        .form {
            width: 100%;
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
            <form class = 'form' action="car_report.php" method="GET">
                <input class="report-day" type="date" name="report-day" value="<?php echo htmlspecialchars($selected_date); ?>">
                <input class="report-day" type="submit" value="Filter">
            </form>
            <?php if (count($car_status_data) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Car ID</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($car_status_data as $car): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($car['car_id']); ?></td>
                        <td><?php echo htmlspecialchars($car['model']); ?></td>
                        <td><?php echo htmlspecialchars($car['status']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p class="no-data">No data available for the selected date.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>