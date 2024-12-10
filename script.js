function openReservationModal(carId, pricePerDay) {
    document.getElementById('car-id').value = carId;
    document.getElementById('price-per-day').value = pricePerDay;
    document.getElementById('reservation-modal').style.display = 'block';
}

function calculateTotalPrice() {
    var startDate = new Date(document.getElementById('start-date').value);
    var endDate = new Date(document.getElementById('end-date').value);
    var pricePerDay = parseFloat(document.getElementById('price-per-day').value);

    if (startDate && endDate && pricePerDay) {
        // Normalize the time to midnight to avoid timezone issues
        startDate.setHours(0, 0, 0, 0);
        endDate.setHours(0, 0, 0, 0);

        // Calculate the difference in days
        var timeDiff = endDate.getTime() - startDate.getTime();
        var days = timeDiff / (1000 * 3600 * 24);

        var totalPrice = days * pricePerDay;
        document.getElementById('total-price').textContent = 'Total Price: ' + totalPrice.toFixed(2) + ' LE';
        document.getElementById('total-price-input').value = totalPrice.toFixed(2);
    }
}

function closeReservationModal() {
    document.getElementById('reservation-modal').style.display = 'none';
}
