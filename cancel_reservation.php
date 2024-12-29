<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reservation_id'])) {
    $reservation_id = $_POST['reservation_id'];

    // Fetch the car_id associated with the reservation
    $query = "SELECT car_id FROM Reservations WHERE reservation_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $reservation_id);
    $stmt->execute();
    $stmt->bind_result($car_id);
    $stmt->fetch();
    $stmt->close();

    // Check if the reservation exists
    if ($car_id) {
        // Update the car status to 'active' (indicating it's available)
        $update_car_status = $conn->prepare("UPDATE Cars SET status = 'active' WHERE car_id = ?");
        $update_car_status->bind_param("i", $car_id);
        
        if ($update_car_status->execute()) {
            // Successfully updated the car status

            // Delete the reservation from the Reservations table
            $delete_reservation = $conn->prepare("DELETE FROM Reservations WHERE reservation_id = ?");
            $delete_reservation->bind_param("i", $reservation_id);
            
            if ($delete_reservation->execute()) {
                // Reservation deleted successfully
                $_SESSION['success_message'] = "Reservation canceled and car status updated to 'active'.";
            } else {
                // Error deleting the reservation
                $_SESSION['error_message'] = "Failed to delete the reservation.";
            }
            $delete_reservation->close();
        } else {
            // Error updating the car status
            $_SESSION['error_message'] = "Failed to update the car status.";
        }
        $update_car_status->close();
    } else {
        // Reservation not found
        $_SESSION['error_message'] = "Reservation not found.";
    }
}

// Redirect to the reservations page with a success or error message
header("Location: view_reserved.php");
exit();
?>
