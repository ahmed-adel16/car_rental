<?php
session_start(); // Initialize session

require_once 'db_connect.php';
// Ensure the user is logged in as admin
if (!isset($_SESSION['admin_id'])) {
    // Redirect to login page if not an admin
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $model = $_POST['model'];
    $year = intval($_POST['year']);
    $price = floatval($_POST['price_per_day']);
    $status = $_POST['status'];
    $image_name = $_POST['car-image'];
    $office_name = $_POST['office-name'];

    // Fetch the office ID based on the office name
    $office_sql = 'SELECT office_id FROM offices WHERE office_name = ?';
    $stmt = $conn->prepare($office_sql);
    $stmt->bind_param("s", $office_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if ($row) {
        $office_id = $row['office_id'];

        // Insert car into the database
        $sql = "INSERT INTO cars (model, year, price_per_day, status, image, office_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sidssi", $model, $year, $price, $status, $image_name, $office_id);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = 'car added successfully';
        } else {
            $_SESSION['error_message'] = 'invalid inputs';
        }

        $stmt->close();
    } else {
        $_SESSION['error_message'] = 'office is not found';
    }

    $conn->close();
    header("Location: add_car.php"); // Redirect back to the form
    exit;
}


$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
unset($_SESSION['success_message']);
unset($_SESSION['error_message']);

$style = '
            "
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
            font-weight: bold;
            "
        ';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Car - Car Rental</title>
    <link rel="stylesheet" href="style.css">
    <style>

        input[type="text"], input[type="number"], input[type="email"], select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 20px; /* Fully rounded corners for oval shape */
            border: 1px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;
        }

        /* Style for the location dropdown */
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 20px; /* Oval shape for select dropdown */
            border: 1px solid #ccc;
            font-size: 16px;
            background-color: #fff;
        }
        .success {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
            font-weight: bold;
        }
        .success {
            background-color: #880000;
            color: white;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
            font-weight: bold;
        }
    </style>
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
            <h2>Add Car</h2>

            <?php if ($success_message): ?>
                <div class="success">
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <div class="error">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>


            <!-- Add Car Form -->
            <form action="add_car.php" method="POST">

                <input type="text" id="model" name="model" placeholder = 'Model' required>

                <input type="number" id="year" name="year" placeholder = 'Year' required>

                <input type="text" id="plate-id" name="plate-id" placeholder = 'Plate ID' required>

                <select id="status" name="status" required>
                    <option value="" disabled selected>Status</option>
                    <option value="active">Active</option>
                    <option value="out of service">Out of Service</option>
                    <option value="rented">Rented</option>
                    <option value="rented">Upcoming</option>
                </select>

                <input  type="number" id="price_per_day" name="price_per_day" step="10" placeholder = 'Price per day' required>

                <select id="office-name" name="office-name" placeholder = 'Office name' required>
                    <?php
                        $query = "SELECT office_name FROM offices";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . htmlspecialchars($row['office_name']) . '">' . ucfirst($row['office_name']) . '</option>';
                            }
                        } else {
                            echo '<option value="">No locations available</option>';
                        }

                        $conn->close(); // Close the database connection
                    ?>
                </select>                
                
                <label class = 'custom-file-label' for="car-image">Upload Image</label>
                <input class = 'upload-btn' type="file" name="car-image" id="car-image" accept = 'image/*' required>
                        
                <input type="submit" class="btn" value="Add Car">

            </form>

            <form action="admin_dashboard.php" method="GET">
                <input type="submit" class="btn" value="Back to Dashboard">
            </form>

        </div>
    </div>
</body>
</html>
