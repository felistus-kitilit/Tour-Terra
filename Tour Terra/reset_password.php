<?php
session_start();

function isStrongPassword($password) {
    return preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect("localhost", "root", "", "tourterra");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $token = $_POST['token'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword= $_POST['confirmPassword'];

     // Check if new password and confirm password match
     if ($newPassword !== $confirmPassword) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: reset_password.php?token=" . htmlspecialchars($token));
        exit();
    }


    if (!isStrongPassword($newPassword)) {
        $_SESSION['error'] = "Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character.";
        header("Location: reset_password.php?token=" . htmlspecialchars($token));
        exit();
    }

    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Verify the token
    $stmt = $conn->prepare("SELECT * FROM password_resets WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $reset = $result->fetch_assoc();
        $email = $reset['email'];

        // Update the user's password
        $stmt = $conn->prepare("UPDATE users SET Password = ? WHERE Email = ?");
        $stmt->bind_param("ss", $hashedPassword, $email);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Password has been updated successfully.";
            // Delete the token after successful reset
            $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();
        } else {
            $_SESSION['error'] = "Failed to update password.";
        }
    } else {
        $_SESSION['error'] = "Invalid or expired token.";
    }

    $stmt->close();
    mysqli_close($conn);
    header("Location: Login1.php");
    exit();
}
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="CSS/stylesheet.css" rel="stylesheet" />
</head>
<title>Forgot Password</title>
<body>
    <div id="logo">
        <img src="Images/TourLogo.png" style="padding-left: 750px;padding-right: 500px; height:100px; width:110px;padding-top: 20px;padding-bottom: 0px;" />
        <img src="Images/name.png" style="padding-left: 725px;padding-right: 500px;"/>
       
    </div>
    <div>
    <header>
        <a href="Home.html">Home</a>
        <a href="About.html">About</a>
        <a href="Contact.html">Contact</a>
        <a href="Login1.php">login</a>
    </header>
    </div>
<div style="height: 100px;"></div>
<div class ="container"  >
<div class="login-form">
            <form action="reset_password.php" method="post">
                <h2 style="color:#4F7942">Reset Password</h2>
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
                <label for="newPassword">New Password</label>
                <input type="password" id="newPassword" name="newPassword" required>
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
                <button type="submit" style="border-radius: 40px;background-color: #4F7942;color: white;height: max-content;">Submit</button>
            </form>
            <?php if (isset($_SESSION['error'])): ?>
                <p style="color: red;"><?php echo htmlspecialchars($_SESSION['error']); ?></p>
                <?php unset($_SESSION['error']); // Clear the error message after displaying it ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['success'])): ?>
                <p style="color: green;"><?php echo htmlspecialchars($_SESSION['success']); ?></p>
                <?php unset($_SESSION['success']); // Clear the success message after displaying it ?>
            <?php endif; ?>
        
      
</div>
</div>
</div>
<div style="height: 100px;"></div>
<div id="footer">
<footer>
    <div class="footer-content">
        <h3>TourTerra</h3>
    </div>
    <p>Explore working farms, learn about sustainable practices, and savor the bounty of the land. 
        Let us guide you on a rustic adventure that will reconnect you with the earth and its wholesome goodness.</p>
    <ul class="socials">
        <li>
            <a href="">
                <img src="Images/facebook.png" />
            </a>
        </li>
        <li>
            <a href="">
                <img src="Images/linkedin.png" />
            </a>
        </li>
        <li>
            <a href="">
                <img src="Images/instagram.png" />
            </a>
        </li>
        <li>
            <a href="">
                <img src="Images/tweeter.png" />
            </a>
        </li>

    </ul>
    <h4 style="text-align:center;">©2023 by TourTerra</h4>
   
</footer>
</div>

</body>
</html>