<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect("localhost", "root", "", "tourterra");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $FarmName = $_SESSION['FarmName'];
    $FullName = $_POST['FullName'];
    $Tourist = $_SESSION['UserName'];
    $Farmer = $_SESSION['Farmer'];
    $Email = $_POST['email'];
    $Phone = $_POST['phone'];
    $People = $_POST['people'];
    $Date = $_POST['datepicker'];

    

    // Check if the selected date exists in the 'schedule' table
    $check_stmt = $conn->prepare("SELECT Availability FROM schedule WHERE FarmName = ? AND Date = ?");
    $check_stmt->bind_param("ss", $FarmName, $Date);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $row = $check_result->fetch_assoc();
        $availability = $row['Availability'];

        if ($availability == 'available') {
            // Date is available, insert into 'bookings' table with 'Status' as 'booked'
            $insert_stmt = $conn->prepare("INSERT INTO bookings (FarmName, FullName, Tourist, Farmer, Email, Phone, People, Date, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'booked')");
            $insert_stmt->bind_param("ssssssis", $FarmName, $FullName, $Tourist, $Farmer, $Email, $Phone, $People, $Date);
            $insert_stmt->execute();
            $_SESSION['success'] = "Booked successfully!";
            header("Location: Book1.php");
            exit;
        } elseif ($availability == 'unavailable') {
            // Date is unavailable
            $_SESSION['error'] = "Selected date is not available. Please choose another date.";
            header("Location: Book1.php");
            exit;
        } else {
            // Handle unexpected availability value
            $_SESSION['error'] = "Unexpected availability status. Please contact support.";
            header("Location: Book1.php");
            exit;
        }
    } else {
        // Date does not exist in the 'schedule' table, insert with 'Status' as 'pending'
        $insert_stmt = $conn->prepare("INSERT INTO bookings (FarmName, FullName, Tourist, Farmer, Email, Phone, People, Date, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
        $insert_stmt->bind_param("ssssssis", $FarmName, $FullName, $Tourist, $Farmer, $Email, $Phone, $People, $Date);
        $insert_stmt->execute();
        $_SESSION['success'] = "Your booking status is pending, wait for the farmer to confirm.";
        header("Location: Book1.php");
        exit;
    }

    // Close statements and connection
    $check_stmt->close();
    $insert_stmt->close();
    mysqli_close($conn);
} else {
    // Redirect to the booking page if accessed directly without form submission
    header("Location: Book1.php");
    exit;
}
?>
