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
$Speciality=$_POST['Speciality'];
$Password = isset($_POST['Password']) ? $_POST['Password'] : '';
$Cpassword=$_POST['Cpassword'];



function validatePassword($Password) {
    // Add your password strength validation logic here
    // For example, check length, special characters, etc.
    return (strlen($Password) >= 8 && preg_match("/[a-z]/", $Password) && preg_match("/[A-Z]/", $Password) && preg_match("/[0-9]/", $Password));
}

// Function to check if username already exists
function usernameExists($UserName, $conn) {
    $sql = $conn->prepare("SELECT * FROM farmers WHERE UserName = ?");
    $sql->bind_param("s", $UserName);
    $sql->execute();
    $result = $sql->get_result();
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
$data = $conn->prepare("INSERT INTO farmers (UserName,Email,Address,Phone,Speciality,Password) VALUES (?, ?, ?, ?, ?, ?)");
$data->bind_param("ssssss",$UserName,$Email,$Address,$Phone,$Speciality,$hashedPassword);
//$check = mysqli_query($conn,$data);

if($data->execute()){
    $_SESSION['success'] = "registerd successfully";

}
else{
    $_SESSION['error'] = "error occured";
}

}
header("Location: Fsignup1.php");
exit;

?>