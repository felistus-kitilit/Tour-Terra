<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "tourterra");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name = $_POST['Name'];
    $Description = $_POST['Description'];
    $Address = $_POST['Address'];
    $Activities = $_POST['Activities'];
    $Schedule = $_POST['Schedule'];
    $Charges = $_POST['Charges'];
    $Contact = $_POST['Contact'];
    $Farmer = $_SESSION['UserName'];

    function nameExists($Name, $conn) {
        $sql = $conn->prepare("SELECT * FROM farms WHERE Name = ?");
        $sql->bind_param("s", $Name);
        $sql->execute();
        $result = $sql->get_result();
        return ($result->num_rows > 0);
    }

    if (nameExists($Name, $conn)) {
        $_SESSION['error']  ="Farm Name already exists.";
        header("Location: FAdd1.php");
        exit;

    } 

    if (isset($_FILES['Image'])) {
        $file_name = $_FILES['Image']['name'];
        $file_size = $_FILES['Image']['size'];
        $file_tmp = $_FILES['Image']['tmp_name'];
        $file_type = $_FILES['Image']['type'];
        $file_ext = end(explode('.', $_FILES['Image']['name']));
        $file_ext = strtolower($file_ext);

        $extensions = array("jpeg", "jpg", "png");

        if (in_array($file_ext, $extensions) === false) {
            $_SESSION['error'] = "extension not allowed, please choose a JPEG or PNG file.";
        } elseif ($file_size > 2097152) {
            $_SESSION['error'] = 'File size must be less than 2 MB';
        } else {
            move_uploaded_file($file_tmp, "uploads/" . $file_name);
            $stmt = $conn->prepare("INSERT INTO farms (Name, Image, Description, Activities, Schedule, Charges, Contact, Farmer, Address) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)");
            $stmt->bind_param("sssssssss", $Name, $file_name, $Description, $Activities, $Schedule, $Charges, $Contact, $Farmer, $Address);

        if ($stmt->execute()) {
         $_SESSION['success'] = "Farm Added successfully";
         header("Location: FAdd1.php");
        exit;
       } else {
       $_SESSION['error'] = "Error occurred";
       header("Location: FAdd1.php");
       exit;
       }
        }
    }
}
?>
