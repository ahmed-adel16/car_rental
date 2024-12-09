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
        
    <aside class="sidebar">
        <h3>
            Filter
        </h3>
        <form method="GET" action="filter_results.php">
            <ul>
                <li>
                    <label for="price-range">Price Range:</label>
                    <select id="price-range" name="price_range">
                        <option value="" disabled selected>Select Price</option>
                        <option value="low">1000 L.E - 2000 L.E/day</option>
                        <option value="medium">2000 L.E - 3000 L.E/day</option>
                        <option value="high">3000+ L.E/day</option>
                    </select>
                </li>
                <li>
                    <label for="car-location">Location:</label>
                    <select id="car-location" name="car-location">
                    <option value="" disabled selected>Choose city</option>
                    <?php
                        $query = "SELECT DISTINCT location FROM offices";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . htmlspecialchars($row['location']) . '">' . ucfirst($row['location']) . '</option>';
                            }
                        } else {
                            echo '<option value="">No locations available</option>';
                        }

                        $conn->close(); // Close the database connection
                    ?>
                    </select>
                </li>
                <li>
                    <label for="car-year">Year:</label>
                    <select id="car-year" name="car-year">
                    <option value="" disabled selected>Select Year</option>
                        <?php 
                            for ($year = 1990; $year <= 2025; $year++){
                                echo "<option value= '$year' >$year</option<br>";
                            }
                        ?>
                    </select>
                </li>
                <li><button class = 'btn' type="submit">Apply Filters</button></li>
            </ul>
        </form>
    </aside>

        <div class="car-container">
            <?php foreach ($cars as $car): ?>
                <div class="car-card">
                    <img src="images/cars/<?php echo htmlspecialchars($car['image']); ?> " >
                    <div class="description">
                        <h2 class = 'car-model'> <?php echo htmlspecialchars($car['model'])?></h2>
                        <h4 class = 'office-name' style = 'color : "#eee"'>Office Name: <?php echo htmlspecialchars($car['office_name'])?></h3>
                        <h5 class = 'office-location' style = 'color : "#eee"'>Location: <?php echo htmlspecialchars($car['location'])?></h3>
                        <p class = 'car-price'>Price: <?php echo round(htmlspecialchars($car['price_per_day']), 1)?> LE</p>
                        <p class = 'car-year'>Model: <?php echo htmlspecialchars($car['year'])?></p>
                        <?php
                            $card_color = '';
                            if ($car['status'] == 'active') {
                                $card_color = 'color: green;';
                            } elseif ($car['status'] == 'rented') {
                                $card_color = 'color: red;';
                            } elseif ($car['status'] == 'out of service') {
                                $card_color = 'color: yellow;';
                            }
                        ?>
                        <span class = 'car-status' style = "<?php echo $card_color; ?>">
                            <?php
                                echo ucfirst(htmlspecialchars($car['status']));
                            ?>
                        </span>
                    </div>
                    <form action="reserve.php" method = 'POST'>
                        <input type="hidden" name="car_id" value= "<?php echo htmlspecialchars($car['car_id']); ?>">
                        <button class = 'reserve-btn' type = 'submit'>Reserve Now</button>
                    </form>
                </div>  
            <?php endforeach ?>  
        </div>
    </section>
</body>
</html>
