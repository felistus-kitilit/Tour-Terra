<?php
session_start(); // Start the session

// Check if ID is set
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect("localhost", "root", "", "tourterra");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $name = $_POST['name'];
    $_SESSION['name1'] = $_POST['name'];
    $Farmer = $_SESSION['UserName'];
    $date = $_POST['datepicker'];
    $action = $_POST['action'];

if ($action == "available") {
    // Check if the date is empty
    if (empty($date)) {
        $_SESSION['success'] = "please select date";
        header("Location: Schedule1.php");
      exit;
    } else {
        // Check if the date already exists for the farm
        $stmt = $conn->prepare("SELECT * FROM schedule WHERE FarmName = ? AND Farmer = ? AND Date = ?");
        $stmt->bind_param("sss", $name, $Farmer, $date);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update the availability column to 'available'
            $update_stmt = $conn->prepare("UPDATE schedule SET Availability = 'available' WHERE FarmName = ? AND Farmer = ? AND Date = ?");
            $update_stmt->bind_param("sss", $name, $Farmer, $date);
            $update_stmt->execute();
            $_SESSION['success']= "Date saved as available.";
            header("Location: Schedule1.php");
      exit;
        } else {
            // Insert into the schedule table
            $insert_stmt = $conn->prepare("INSERT INTO schedule (FarmName, Farmer, Date, availability) VALUES (?, ?, ?, 'available')");
            $insert_stmt->bind_param("sss", $name, $Farmer, $date);
            $insert_stmt->execute();
            $_SESSION['success']="Date saved as available.";
            header("Location: Schedule1.php");
      exit;
        }
    }
} 
}
if ($action == "notavailable") {
    // Check if the date is empty
    if (empty($date)) {
        $_SESSION['success'] = "please select date";
        header("Location: Schedule1.php");
      exit;
    } else {
        // Check if the date already exists for the farm
        $stmt = $conn->prepare("SELECT * FROM schedule WHERE FarmName = ? AND Farmer = ? AND Date = ?");
        $stmt->bind_param("sss", $name, $Farmer, $date);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update the availability column to 'available'
            $update_stmt = $conn->prepare("UPDATE schedule SET Availability = 'unavailable' WHERE FarmName = ? AND Farmer = ? AND Date = ?");
            $update_stmt->bind_param("sss", $name, $Farmer, $date);
            $update_stmt->execute();
            $_SESSION['success']= "Date saved as unavailable.";
            header("Location: Schedule1.php");
      exit;
        } else {
            // Insert into the schedule table
            $insert_stmt = $conn->prepare("INSERT INTO schedule (FarmName, Farmer, Date, availability) VALUES (?, ?, ?, 'unavailable')");
            $insert_stmt->bind_param("sss", $name, $Farmer, $date);
            $insert_stmt->execute();
            $_SESSION['success']="Date saved as unavailable.";
            header("Location: Schedule1.php");
      exit;
        }
    }
} 

else {
    // Handle invalid request
    $_SESSION['success']= "Invalid request";
    header("Location: Schedule1.php");
      exit;
}

// Close the connection
mysqli_close($conn);



    

?>