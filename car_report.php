<?php
session_start(); // Initialize session
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Ensure the user is logged in as admin
if (!isset($_SESSION['admin_id'])) {

    // Redirect to login page if not an admin
    header("Location: admin_login.php");
    exit();
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
            text-align: center;
            font-size: 20px;
            color: red;
        }

        .report-day {
            width: 150px !important;
            margin-left: 30px;

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
            <input type="date" name="report-day" class = 'report-day'>
            <form action="car_report.php" method = 'GET'>
                <input class = 'report-day' type = 'submit' value = 'Filter'>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>Car ID</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>       
                </thead>
                <tbody>
                    <tb>
                        <td>1</td>
                        <td>2024-10-19</td>
                        <td>Active</td>
                    </tb>
                </tbody>
                
            </table>
        </div>
    </div>
</body>
</html>
