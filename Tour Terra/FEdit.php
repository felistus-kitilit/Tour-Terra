<?php
session_start(); // Start the session

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect("localhost", "root", "", "tourterra");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $name = $_POST['name'];
    $_SESSION['name1'] = $_POST['name'];
    $description = $_POST['description'];
    $address = $_POST['address'];
    $activities = $_POST['activities'];
    $schedule = $_POST['schedule'];
    $charges = $_POST['charges'];
    $contact = $_POST['contact'];

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        move_uploaded_file($imageTmpName, "uploads/" . $imageName);
    } else {
        // If no new image is uploaded, do not update the image name
        // This assumes $imageName is already set to the existing image name from the database
        $stmt = $conn->prepare("SELECT Image FROM farms WHERE Name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->bind_result($existingImageName);
        $stmt->fetch();
        $stmt->close();
        $imageName = $existingImageName; // Use the existing image name
    }
    // Prepare and bind
    $stmt = $conn->prepare("UPDATE farms SET Name = ?, Image = ?, Description = ?, Activities = ?, Schedule = ?, Charges = ?, Contact = ?, Address = ? WHERE Name = ?");
    $stmt->bind_param("sssssssss", $name, $imageName, $description, $activities, $schedule, $charges, $contact, $address, $name);

    $stmt->execute();
    if ($stmt->error) {
        echo "Error: " . $stmt->error;
    }


     
    
    $_SESSION['success'] = "saved successfully";

    // Close statement
    $stmt->close();
    // Close connection
    $conn->close();

    header("Location: FEdit1.php");
      exit;
}
?>