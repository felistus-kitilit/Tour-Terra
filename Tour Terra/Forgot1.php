<?php
session_start(); // Start the session
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="CSS/stylesheet.css" rel="stylesheet" />
</head>
<title>Login</title>
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
        
        <div style="width:100px"></div>
    <div class="login-form">
  <form action="Forgot.php" method="post">
    <div class="form-group">
        <h2 style="color:#4F7942">Forgot Password</h2>
        
      <label for="UserName">Enter User Name</label>
      <input type="text" id="UserName" name="UserName" required>

    <button type="submit" style="border-radius: 40px;background-color: #4F7942;color: white;height: max-content;">Submit</button>
    
  </form>
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