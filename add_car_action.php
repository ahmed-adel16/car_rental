<?php
require 'db_connect.php'; // Include your DB connection

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
            echo "Car added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Office not found.";
    }

    $conn->close();
    header("Location: add_car.php"); // Redirect back to the form
    exit;
}
?>
