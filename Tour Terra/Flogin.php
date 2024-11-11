<?php
session_start();
$conn= mysqli_connect("localhost","root","","tourterra");
if($conn){
    //echo "connected";
}
else{
    echo "failed";
}
$UserName=$_POST['UserName'];
$Password=$_POST['Password'];

$sql = $conn->prepare("SELECT * FROM farmers WHERE UserName = ? ");
$sql->bind_param("s", $UserName);
$sql->execute();
$result = $sql->get_result();
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $hashedPassword = $user['Password'];

    if (password_verify($Password, $hashedPassword)) {
        // Password matches, user is logged in
        $_SESSION['UserName'] = $UserName;
        header("Location: FAdd1.php");
        exit;
    } else {
        // Password does not match
        $_SESSION['error'] = "Invalid username or password";
        header("Location: Flogin1.php");
        exit;
    }
    
} 
else {
    // Username and password do not match
    $_SESSION['error'] = "Invalid username or password";
    header("Location: Flogin1.php");
exit;
}
$sql->close();
mysqli_close($conn);


?>