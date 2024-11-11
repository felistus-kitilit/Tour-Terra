<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect("localhost", "root", "", "tourterra");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    $username = $_POST['UserName'];

    // Verify if the username exists
    $stmt = $conn->prepare("SELECT * FROM tourists WHERE UserName = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $email = $user['Email'];
        $token = bin2hex(random_bytes(50)); // Generate a unique token

        // Insert the token into a password_reset table
        $stmt = $conn->prepare("INSERT INTO password_resets (email, token) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $token);
        if ($stmt->execute()) {
            // Send the email
            $resetLink = "http://localhost/Tour%20Terra/reset_password.php?token=" . $token;
            $subject = "Password Reset Request";
            $message = "Hello, " . $username . ". Click on the link below to reset your password: " . $resetLink;
            $headers = "jebetfelistus955@gmail.com";

            if (mail($email, $subject, $message, $headers)) {
                $_SESSION['success'] = "Password reset link has been sent to your email.";
            } else {
                $_SESSION['error'] = "Failed to send reset email.";
            }
        } else {
            $_SESSION['error'] = "Failed to generate reset link.";
        }
    } else {
        $_SESSION['error'] = "Username not found.";
    }

    $stmt->close();
    mysqli_close($conn);
    header("Location: Forgot1.php");
    exit();
}
?>
