<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect("localhost", "root", "", "tourterra");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $id = $_POST['id'];
    $action = $_POST['action'];
    $_SESSION['name2'] = $_POST['id'];

    // Determine the new status based on the action
    $new_status = '';
    if ($action == 'Accept') {
        $new_status = 'booked';
    } elseif ($action == 'Decline') {
        $new_status = 'declined';
    }

    if ($new_status) {
        $stmt = $conn->prepare("UPDATE bookings SET Status = ? WHERE BookingID = ?");
        $stmt->bind_param("si", $new_status, $id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Booking status updated successfully.";
        } else {
            $_SESSION['error'] = "Error updating booking status.";
        }

        $stmt->close();
    }

    $conn->close();

    // Redirect back to the bookings page
    header("Location: Fbookings1.php");
    exit();


}



?>