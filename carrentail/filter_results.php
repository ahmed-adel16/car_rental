<?php
session_start();
include 'db_connect.php';
$price_range = $_GET['price_range'] ?? '';
$car_type = $_GET['car_type'] ?? '';


$sql = "SELECT * FROM cars WHERE 1=1";

if ($price_range === 'low') {
    $sql .= " AND price_per_day >= 0 AND price_per_day <= 50";
} elseif ($price_range === 'medium') {
    $sql .= " AND price_per_day > 50 AND price_per_day <= 100";
} elseif ($price_range === 'high') {
    $sql .= " AND price_per_day > 100";
}

if ($car_type) {
    $sql .= " AND type = '$car_type'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='car-card'>";
        echo "<img src='images/cars/{$row['image']}' alt='{$row['name']}'>";
        echo "<div class='description'>";
        echo "<h2>{$row['name']}</h2>";
        echo "<span>{$row['description']}</span>";
        echo "<p>Price: \${$row['price']}/day</p>";
        echo "<form method='POST'>";
        echo "<button class='reserve-btn' type='submit'>Reserve Now</button>";
        echo "</form>";
        echo "</div></div>";
    }
} else {
    echo "<p>No matching cars</p>";
}
?>
