<?php
session_start();

// Placeholder logic for reservation (adjust as needed)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process reservation here (e.g., save the car reservation to the database)
    $_SESSION['success_message'] = "Reservation successful!";
    header("Location: reserve.php");
    exit();
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
            <li><a href="user_home.php">↩ Log out</a></li>
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
                        <option value="">Select Price</option>
                        <option value="low">$0 - $50/day</option>
                        <option value="medium">$50 - $100/day</option>
                        <option value="high">$100+/day</option>
                    </select>
                </li>
                <li>
                    <label for="car-type">Car Type:</label>
                    <select id="car-type" name="car_type">
                        <option value="">Select Car Type</option>
                        <option value="suv">SUV</option>
                        <option value="sedan">Sedan</option>
                        <option value="electric">Electric</option>
                    </select>
                </li>
                <li><button class = 'btn' type="submit">Apply Filters</button></li>
            </ul>
        </form>
    </aside>

        <div class="car-container">
            <div class="car-card">
                <img src="images/cars/bmw-ix.png" alt="BMW IX">
                <div class="description">
                    <h2>BMW IX</h2>
                    <span>Full-Electric, 300-mile range, Luxury SUV</span>
                    <p>Price: $70/day</p>
                    <form method="POST">
                        <button class="reserve-btn" type="submit">Reserve Now</button>
                    </form>
                    <!-- Removed Reserve button and form -->
                </div>
            </div>
            <div class="car-card">
                <img src="images/cars/bmw-i7.png" alt="BMW I7">
                <div class="description">
                    <h2>BMW I7</h2>
                    <span>Full-Electric, 320-mile range, Premium Sedan</span>
                    <p>Price: $90/day</p>
                    <form method="POST">
                        <button class="reserve-btn" type="submit">Reserve Now</button>
                    </form>
                    <!-- Removed Reserve button and form -->
                </div>
            </div>
            <div class="car-card">
                <img src="images/cars/bmw-i5.png" alt="BMW I5">
                <div class="description">
                    <h2>BMW I5</h2>
                    <span>Full-Electric, 280-mile range, Stylish Design</span>
                    <p>Price: $80/day</p>
                    <form method="POST">
                        <button class="reserve-btn" type="submit">Reserve Now</button>
                    </form>
                    <!-- Removed Reserve button and form -->
                </div>
            </div>
            <div class="car-card">
                <img src="images/cars/bmw-ix2.png" alt="BMW IX2">
                <div class="description">
                    <h2>BMW IX2</h2>
                    <span>Full-Electric, 280-mile range, Stylish Design</span>
                    <p>Price: $100/day</p>
                    <form method="POST">
                        <button class="reserve-btn" type="submit">Reserve Now</button>
                    </form>

                </div>
            </div>
            <div class="car-card">
                <img src="images/cars/bmw-ix2.png" alt="BMW IX2">
                <div class="description">
                    <h2>BMW IX2</h2>
                    <span>Full-Electric, 280-mile range, Stylish Design</span>
                    <p>Price: $100/day</p>
                    <form method="POST">
                        <button class="reserve-btn" type="submit">Reserve Now</button>
                    </form>

                </div>
            </div>
            <div class="car-card">
                <img src="images/cars/bmw-ix2.png" alt="BMW IX2">
                <div class="description">
                    <h2>BMW IX2</h2>
                    <span>Full-Electric, 280-mile range, Stylish Design</span>
                    <p>Price: $100/day</p>
                    <form method="POST">
                        <button class="reserve-btn" type="submit">Reserve Now</button>
                    </form>

                </div>
            </div>
            <div class="car-card">
                <img src="images/cars/bmw-ix2.png" alt="BMW IX2">
                <div class="description">
                    <h2>BMW IX2</h2>
                    <span>Full-Electric, 280-mile range, Stylish Design</span>
                    <p>Price: $100/day</p>
                    <form method="POST">
                        <button class="reserve-btn" type="submit">Reserve Now</button>
                    </form>

                </div>
            </div>
            <div class="car-card">
                <img src="images/cars/bmw-ix2.png" alt="BMW IX2">
                <div class="description">
                    <h2>BMW IX2</h2>
                    <span>Full-Electric, 280-mile range, Stylish Design</span>
                    <p>Price: $100/day</p>
                    <form method="POST">
                        <button class="reserve-btn" type="submit">Reserve Now</button>
                    </form>

                </div>
            </div>
            <div class="car-card">
                <img src="images/cars/bmw-ix2.png" alt="BMW IX2">
                <div class="description">
                    <h2>BMW IX2</h2>
                    <span>Full-Electric, 280-mile range, Stylish Design</span>
                    <p>Price: $100/day</p>
                    <form method="POST">
                        <button class="reserve-btn" type="submit">Reserve Now</button>
                    </form>

                </div>
            </div>
            <div class="car-card">
                <img src="images/cars/bmw-ix2.png" alt="BMW IX2">
                <div class="description">
                    <h2>BMW IX2</h2>
                    <span>Full-Electric, 280-mile range, Stylish Design</span>
                    <p>Price: $100/day</p>
                    <form method="POST">
                        <button class="reserve-btn" type="submit">Reserve Now</button>
                    </form>

                </div>
            </div>
            <div class="car-card">
                <img src="images/cars/bmw-ix2.png" alt="BMW IX2">
                <div class="description">
                    <h2>BMW IX2</h2>
                    <span>Full-Electric, 280-mile range, Stylish Design</span>
                    <p>Price: $100/day</p>
                    <form method="POST">
                        <button class="reserve-btn" type="submit">Reserve Now</button>
                    </form>

                </div>
            </div>
            <div class="car-card">
                <img src="images/cars/bmw-ix2.png" alt="BMW IX2">
                <div class="description">
                    <h2>BMW IX2</h2>
                    <span>Full-Electric, 280-mile range, Stylish Design</span>
                    <p>Price: $100/day</p>
                    <form method="POST">
                        <button class="reserve-btn" type="submit">Reserve Now</button>
                    </form>

                </div>
            </div>
        </div>
    </section>
</body>
</html>
