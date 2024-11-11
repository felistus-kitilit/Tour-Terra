<?php
session_start(); // Start the session


?>


<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="CSS/stylesheet.css" rel="stylesheet" />
    <link href="CSS/style.css" rel="stylesheet" />
    <!-- Include jQuery and jQuery UI -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
    $(function() {
        console.log("Datepicker initialization script executed.");
        // Initialize datepickers
        $("#datepicker").datepicker({
            minDate: 0, // Disable past dates
            dateFormat: "yy-mm-dd" // Set date format

            
        });

    });
</script>
    
</head>
<title>Tourist profile</title>
<body>
    <div id="logo">
        <img src="Images/TourLogo.png" style="padding-left: 750px;padding-right: 500px; height:100px; width:110px;padding-top: 20px;padding-bottom: 0px;" />
        <img src="Images/name.png" style="padding-left: 725px;padding-right: 500px;"/>
       
    </div>
    
    <div class="MenuContainer" style="padding-top:20px; padding-bottom:30px">
    <div class="menu">

    <p><img src="Images/user.png" /> <?php echo isset($_SESSION['UserName']) ? htmlspecialchars($_SESSION['UserName']) : 'Welcome'; ?></p>
            
            <br />
            <br />
            <br />
            <a href="Tfarms1.php"><img src="Images/add.png" style="height: 22px; width: 34px" />~~Farms</a>
            <br/>
            <br />
            <a href="Tbookings1.php"><img src="Images/bookings.png" style="height: 21px; width: 40px" />~~Bookings</a>
            <br />
            <br />
           <a href="Login1.php"><img src="Images/logout.png" style="height: 22px; width: 33px" />~~LogOut</a>
            <br />
            <br />
        </div>
        <div class="login-form">
  <form action="Book.php" method="post">
    <div class="form-group">
        <h2 style="color:#4F7942">Booking Info</h2>
        
      <label >Full Name</label>
      <input type="text" id="FullName" name="FullName" required>

    </div>
    <div class="form-group">
        <label>Email Address</Address></label>
        <input type="email" id="email" name="email" required>
        
      </div>
      
      <div class="form-group">
        <label>Phone Number</label>
        <input type="text" id="phone" name="phone" required>
        
      </div>
      <div class="form-group">
        <label>Number Of People</label>
        <input type="number" id="people" name="people" step="1" required>
        </div>
      <div class="form-group">
      <label for="datepicker">Select Date:</label>
      <input type="text" id="datepicker" class="datepicker" name="datepicker" placeholder="Click here to select date" required>
      </div>
      <button type="submit" style="border-radius: 40px;background-color: #4F7942;color: white;">Book</button>
      <?php if (isset($_SESSION['error'])): ?>
            <p style="color: red;"><?php echo htmlspecialchars($_SESSION['error']); ?></p>
            <?php unset($_SESSION['error']); // Clear the error message after displaying it ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <p style="color: blue;"><?php echo htmlspecialchars($_SESSION['success']); ?></p>
            <?php unset($_SESSION['success']); // Clear the success message after displaying it ?>
        <?php endif; ?>
    
</form>

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
