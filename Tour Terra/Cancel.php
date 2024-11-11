<?php
session_start(); // Start the session

// Check if ID is set
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect("localhost", "root", "", "tourterra");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $id = $_POST['id'];
    $action = $_POST['action'];
    $_SESSION['name2'] = $_POST['id'];

    if ($action == "Cancel") {
        $stmt = $conn->prepare("UPDATE bookings SET Status = 'Canceled' WHERE BookingID = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Booking canceled successfully";
        } else {
            $_SESSION['success'] = "Failed to cancel booking";
        }
        $stmt->close();
        mysqli_close($conn);
        header("Location: Tbookings1.php");
        exit();
    }
}
?>