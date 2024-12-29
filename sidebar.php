<?php 
$price =  $_GET['price_range'] ?? 1000;

?>
<aside class="sidebar">
            <h3>Filter</h3>
            <form method="GET" action="filter_results.php">
                <ul>
                    <li>
                    <label for="price-range-slider">Price Range:</label>
                    <div class="price-range-slider">
                        <input type="range" id="min-price-slider" name="min_price"
                            min="500" max="3500" step="100"
                            value="<?php echo isset($min_price) ? $min_price : '1000'; ?>"
                            oninput="updatePriceRangeText(this.value, document.getElementById('max-price-slider').value)">
                        <input type="range" id="max-price-slider" name="max_price"
                            min="500" max="3500" step="100"
                            value="<?php echo isset($max_price) ? $max_price : '3000'; ?>"
                            oninput="updatePriceRangeText(document.getElementById('min-price-slider').value, this.value)"><br>
                        <span id="price-range-text"><?php echo isset($min_price) ? $min_price : '1000'; ?> - <?php echo isset($max_price) ? $max_price : '3000'; ?> LE/Day</span>
                    </div>
                    </li>
                    <li>
                        <label for="car-location">Location:</label>
                        <select id="car-location" name="car-location">
                            <option value="" disabled selected>Choose city</option>
                            <?php
                                $query = "SELECT DISTINCT location FROM offices";
                                $locations = $conn->query($query);

                                if ($locations->num_rows > 0) {
                                    while ($row = $locations->fetch_assoc()) {
                                        $selected = ($row['location'] == $car_location) ? 'selected' : '';
                                        echo '<option value="' . htmlspecialchars($row['location']) . '" ' . $selected . '>' . ucfirst($row['location']) . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No locations available</option>';
                                }
                            ?>
                        </select>
                    </li>
                    <li>
                        <label for="car-year">Year:</label>
                        <select id="car-year" name="car-year">
                            <option value="" disabled selected>Select Year</option>
                            <?php
                                for ($year = 1990; $year <= 2025; $year++) {
                                    $selected = ($year == $car_year) ? 'selected' : '';
                                    echo "<option value='$year' $selected>$year</option>";
                                }
                            ?>
                        </select>
                    </li>
                    <li>
                        <label for="car-status">Status:</label>
                        <select id="car-status" name="car-status">
                            <option value="" disabled selected>Select Status</option>
                            <option value="active" <?php if (isset($_GET['car-status']) && $_GET['car-status'] == 'active') echo 'selected'; ?>>Active</option>
                            <option value="rented" <?php if (isset($_GET['car-status']) && $_GET['car-status'] == 'rented') echo 'selected'; ?>>Rented</option>
                            <option value="out of service" <?php if (isset($_GET['car-status']) && $_GET['car-status'] == 'out of service') echo 'selected'; ?>>Out of Service</option>
                        </select>
                    </li>
                    <li><button class="btn" type="submit">Apply Filters</button></li>
                    <a href="reserve.php" class="btn reset-btn" style="text-decoration: none;">Reset Filters</a>
                </ul>
            </form>
        </aside>
<script>
function updatePriceRangeText(min, max) {
    document.getElementById('price-range-text').innerText =  min + ' - ' +  max + ' LE/day';
}

</script>