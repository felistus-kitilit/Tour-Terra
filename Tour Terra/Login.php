<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "tourterra");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$UserName = $_POST['UserName'];
$Password = $_POST['Password'];

$sql = "SELECT * FROM tourists WHERE UserName = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $UserName);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User found, fetch the associated data
    $user = $result->fetch_assoc();
    $hashedPassword = $user['Password'];

    if (password_verify($Password, $hashedPassword)) {
        // Password matches, user is logged in
        $_SESSION['UserName'] = $UserName;
        header("Location: Tfarms1.php");
        exit;
    } else {
        // Password does not match
        $_SESSION['error'] = "Invalid username or password";
        header("Location: login1.php");
        exit;
    }
} else {
    // Username not found
    $_SESSION['error'] = "Invalid username or password";
    header("Location: login1.php");
    exit;
}

$stmt->close();
mysqli_close($conn);
?>

