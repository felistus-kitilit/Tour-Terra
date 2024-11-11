<?php
session_start();
$conn= mysqli_connect("localhost","root","","tourterra");
if($conn){
   // echo "connected";
}
else{
    echo "failed";
}
$UserName=$_POST['UserName'];
$Email=$_POST['Email'];
$Address=$_POST['Address'];
$Phone=$_POST['Phone'];
$Password = isset($_POST['Password']) ? $_POST['Password'] : '';
$Cpassword=$_POST['Cpassword'];



function validatePassword($Password) {
    // Add your password strength validation logic here
    // For example, check length, special characters, etc.
    return (strlen($Password) >= 8 && preg_match("/[a-z]/", $Password) && preg_match("/[A-Z]/", $Password) && preg_match("/[0-9]/", $Password));
}

// Function to check if username already exists
function usernameExists($UserName, $conn) {
    $sql = "SELECT * FROM tourists WHERE UserName = '$UserName'";
    $result = $conn->query($sql);
    return ($result->num_rows > 0);
}
if (usernameExists($UserName, $conn)) {
    $_SESSION['error']  ="Username already exists.";
} 
elseif (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Invalid email format.";
}
elseif (!validatePassword($Password)) {
    
    $_SESSION['error'] ="Password should be at least 8 characters long and contain at least one lowercase letter, one uppercase letter, and one number.";
}
// Check if passwords match
elseif ($Password !== $Cpassword) {
    $_SESSION['error'] = "Passwords do not match.";
}
// Check if username already exists
else{
$hashedPassword = password_hash($Password, PASSWORD_DEFAULT);
$data= "INSERT INTO tourists VALUES('$UserName','$Email','$Address','$Phone','$hashedPassword')";
$check = mysqli_query($conn,$data);

if($check){
    $_SESSION['success'] = "registerd successfully";

}
else{
    $_SESSION['error'] = "error occured";
}

}
header("Location: signup1.php");
exit;

?>