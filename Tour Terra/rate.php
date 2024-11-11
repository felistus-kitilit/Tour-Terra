<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "tourterra");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['FarmName']) && isset($_GET['rating'])) {
    $FarmName = $_GET['FarmName'];
    $_SESSION['name2'] =$_GET['BookingID']; 
    $rating = $_GET['rating'];

    $stmt = $conn->prepare("INSERT INTO ratings (FarmName, Rating) VALUES (?, ?)");
    $stmt->bind_param("si", $FarmName, $rating);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Rating updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update rating: " . mysqli_error($conn);
    }

    $stmt->close();
    mysqli_close($conn);

    header("Location: Tbookings1.php");
    exit();
}
?>

