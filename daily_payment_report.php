<?php
session_start(); // Initialize session
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Ensure the user is logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

require_once 'db_connect.php'; // Database connection

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);

// Initialize variables
$start_date = $end_date = '';
$payments = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Query for reservations within the specified period
    $stmt = $conn->prepare(
        "SELECT r.start_date, r.end_date, c.price_per_day
         FROM Reservations r
         JOIN Cars c ON r.car_id = c.car_id
         WHERE (r.start_date BETWEEN ? AND ?) OR (r.end_date BETWEEN ? AND ?)"
    );

    if ($stmt === false) {
        die('Error preparing the SQL query: ' . $conn->error);
    }

    $stmt->bind_param("ssss", $start_date, $end_date, $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $reservations = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $error_message = "No reservations found for the specified period.";
    }


    error_reporting(0);

    // Generate all dates between start and end date
    $dates = [];
    $start_date += 1;
    $current_date = strtotime($start_date);
    $end_date = strtotime($end_date);

    while ($current_date <= $end_date) {
        $dates[] = date('Y-m-d', $current_date);
        $current_date = strtotime("+1 day", $current_date);
    }

    // Calculate daily payments for each date in the range
    $daily_payments = [];
    foreach ($dates as $date) {
        $daily_payment = 0;
        foreach ($reservations as $reservation) {
            // Check if the reservation overlaps with the current date
            $reservation_start = strtotime($reservation['start_date']);
            $reservation_end = strtotime($reservation['end_date']);

            if ($reservation_start <= strtotime($date) && $reservation_end >= strtotime($date)) {
                // Add the price for this reservation if the date is within the reservation period
                $daily_payment += $reservation['price_per_day'];
            }
        }
        // Store the daily payment for this date
        $daily_payments[] = [
            'payment_date' => $date,
            'daily_payment' => $daily_payment
        ];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Payment Report - Car Rental</title>
    <link rel="stylesheet" href="style.css">
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
            <h2>Daily Payment Report</h2>

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

            <form action="daily_payment_report.php" method="POST">
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date" value="<?php echo htmlspecialchars($start_date); ?>" required>

                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" id="end_date" value="<?php echo htmlspecialchars($end_date); ?>" required>

                <input type="submit" class="btn login-btn" value="Generate Report">
            </form>

            <?php if (!empty($daily_payments)): ?>
                <h3>Report Results:</h3>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Daily Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total_payment = 0;
                        foreach ($daily_payments as $payment): 
                            $total_payment += $payment['daily_payment'];
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($payment['payment_date']); ?></td>
                                <td><?php echo '$' . number_format($payment['daily_payment'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td><strong>Total Payment</strong></td>
                            <td><strong><?php echo '$' . number_format($total_payment, 2); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            <?php endif; ?>

            <button class="btn" onclick="window.location.href='admin_dashboard.php';">Go Back</button>
        </div>
    </div>
</body>
</html>
