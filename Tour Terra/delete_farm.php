<?php
session_start(); // Start the session

// Check if ID is set
if (isset($_GET['id'])) {
    $conn = mysqli_connect("localhost", "root", "", "tourterra");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // Set parameter and execute
    $farm_id = $_GET['id'];
    $name = $_POST['name'];

    // Prepare and bind
    $stmt = $conn->prepare("DELETE FROM farms WHERE Name = ?");
    $stmt->bind_param("s", $farm_id);
    $stmt->execute();

    // Close statement
    $stmt->close();
    // Close connection
    $conn->close();
    header("Location: FEdit1.php");
      exit;
}
?>