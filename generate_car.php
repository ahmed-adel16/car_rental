<?php
function renderCarCards($cars) {
    $output = '<div class="car-container">';
    foreach ($cars as $car) {
        $card_color = '';
        if ($car['status'] === 'active') {
            $card_color = 'color: green;';
        } elseif ($car['status'] === 'rented') {
            $card_color = 'color: red;';
        } elseif ($car['status'] === 'out of service') {
            $card_color = 'color: yellow;';
        }
        
        $output .= '
        <div class="car-card">
            <img src="images/cars/' . htmlspecialchars($car['image']) . '">
            <div class="description">
                <h2 class="car-model">' . htmlspecialchars($car['model']) . '</h2>
                <h4 class="office-name" style="color: #eee;">Office Name: ' . htmlspecialchars($car['office_name']) . '</h4>
                <h5 class="office-location" style="color: #eee;">Location: ' . htmlspecialchars($car['location']) . '</h5>
                <p class="car-price">Price: ' . round(htmlspecialchars($car['price_per_day']), 1) . ' LE</p>
                <p class="car-year">Model: ' . htmlspecialchars($car['year']) . '</p>
                <span class="car-status" style="' . $card_color . '">' . ucfirst(htmlspecialchars($car['status'])) . '</span>
            </div>
            <form action="reserve.php" method="POST">
                <input type="hidden" name="car_id" value="' . htmlspecialchars($car['car_id']) . '">
                <button class="reserve-btn" type="submit">Reserve Now</button>
            </form>
        </div>';
    }
    $output .= '</div>';
    return $output;
}
?>