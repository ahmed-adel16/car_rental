// Open Reservation Modal
function openReservationModal(carId, pricePerDay) {
    const modal = document.getElementById('reservation-modal');
    modal.style.display = 'block';

    // Populate hidden inputs with car ID and price
    document.getElementById('car-id').value = carId;
    document.getElementById('price-per-day').value = pricePerDay;
}

// Close Reservation Modal
function closeReservationModal() {
    const modal = document.getElementById('reservation-modal');
    modal.style.display = 'none';
}

// Calculate Total Price
function calculateTotalPrice() {
    const startDate = new Date(document.getElementById('start-date').value);
    const endDate = new Date(document.getElementById('end-date').value);

    if (startDate && endDate && startDate <= endDate) {
        const timeDiff = endDate - startDate; // Difference in milliseconds
        const days = Math.ceil(timeDiff / (1000 * 60 * 60 * 24)) + 1; // Total days
        const pricePerDay = parseFloat(document.getElementById('price-per-day').value);
        const totalPrice = days * pricePerDay;

        // Update the displayed and hidden total price
        document.getElementById('total-price').textContent = `Total Price: ${totalPrice.toFixed(2)} LE`;
        document.getElementById('total-price-input').value = totalPrice.toFixed(2);
    }
}
