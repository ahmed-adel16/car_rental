<?php
session_start();
require 'db_connect.php'; // Ensure the database connection file is correct

// Ensure the user is logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Initialize filter variables
$customer_name_filter = isset($_GET['customer_name']) ? $_GET['customer_name'] : '';
$car_model_filter = isset($_GET['car_model']) ? $_GET['car_model'] : '';
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Fetch customers for the dropdown
$customer_query = "SELECT customer_id, CONCAT(first_name, ' ', last_name) AS customer_name FROM Customers";
$customer_result = $conn->query($customer_query);

// Fetch cars for the dropdown
$car_query = "SELECT car_id, model FROM Cars";
$car_result = $conn->query($car_query);

// Construct SQL query with optional filters
$sql = "
    SELECT 
        r.reservation_id,
        CONCAT(c.first_name, ' ', c.last_name) AS customer_name,
        car.model AS car_model,
        o.location AS office_location,
        r.start_date,
        r.end_date,
        r.total_price
        FROM Reservations r
    JOIN Customers c ON r.customer_id = c.customer_id
    JOIN Cars car ON r.car_id = car.car_id
    JOIN Offices o ON r.office_id = o.office_id
    WHERE 1
";

// Add filters to the query if provided
if ($customer_name_filter) {
    $sql .= " AND CONCAT(c.first_name, ' ', c.last_name) LIKE '%" . $conn->real_escape_string($customer_name_filter) . "%'";
}

if ($car_model_filter) {
    $sql .= " AND car.model LIKE '%" . $conn->real_escape_string($car_model_filter) . "%'";
}

if ($start_date) {
    $sql .= " AND r.start_date >= '" . $conn->real_escape_string($start_date) . "'";
}

if ($end_date) {
    $sql .= " AND r.end_date <= '" . $conn->real_escape_string($end_date) . "'";
}


// Execute the query
$result = $conn->query($sql);

// Debugging: Check if the query executes successfully and returns results
if ($result) {
    // Query successful
} else {
    die("Query failed: " . $conn->error); // Handle query errors
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reservations</title>
    <link rel="stylesheet" href="style.css">
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
            text-align: center;
            font-size: 20px;
            color: red;
        }

    </style>
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="Auth/logout.php">↩ logout</a></li>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
        </ul>
        <div class="logo">
            <a href="index.php"><img src="images/logo.png" alt="Logo"></a>
        </div>
    </nav>

    <div class="hero">
        <div class="login">
            <h2>Manage Reservations</h2>

            <!-- Filter Form -->
            <form class="filter-form" action="manage_reservations.php" method="GET">
                <select class = 'selection' name="customer_name">
                    <option value="">Select Customer</option>
                    <?php while ($customer = $customer_result->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($customer['customer_name']); ?>" 
                            <?php echo ($customer['customer_name'] == $customer_name_filter) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($customer['customer_name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <select class = 'selection' name="car_model">
                    <option value="">Select Car Model</option>
                    <?php while ($car = $car_result->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($car['model']); ?>" 
                            <?php echo ($car['model'] == $car_model_filter) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($car['model']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <input class = 'selection' type="date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
                <input class = 'selection' type="date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
                

                <button type="submit" class='filter-btn'>Filter</button>
            </form>

            <?php if ($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Reservation ID</th>
                            <th>Customer Name</th>
                            <th>Car Model</th>
                            <th>Office Location</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['reservation_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['car_model']); ?></td>
                                <td><?php echo htmlspecialchars($row['office_location']); ?></td>
                                <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['total_price']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-data">No reservations found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>
