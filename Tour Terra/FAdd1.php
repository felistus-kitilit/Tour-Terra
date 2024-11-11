<?php
session_start(); // Start the session

?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="CSS/stylesheet.css" rel="stylesheet" />
    <link href="CSS/style.css" rel="stylesheet" />
    <link href="CSS/style1.css" rel="stylesheet" />
    
</head>
<title>Add Farm</title>
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
            <a href="FAdd1.php"><img src="Images/add.png" style="height: 22px; width: 34px" />~~Add Farm</a>
            <br/>
            <br />
            <a href="FEdit1.php"><img src="Images/Edit.png" style="height: 21px; width: 34px" />~~Edit Farms</a>
            <br />
            <br />
            <a href="Schedule1.php"><img src="Images/calendar.png" style="height: 21px; width: 34px" />~~Schedule</a>
            <br />
            <br />
            <a href="Fbookings1.php"><img src="Images/bookings.png" style="height: 21px; width: 40px" />~~Bookings</a>
            <br />
            <br />
           <a href="Flogin1.php"><img src="Images/logout.png" style="height: 22px; width: 33px" />~~LogOut</a>
            <br />
            <br />
        </div>
  <div class="login-formmm">
  <form action="FAdd.php" method="post" enctype="multipart/form-data">
    <div class="form-grouppp">
        <h2 style="color:#4F7942">Farmer</h2>
        <h2 style="color:#4F7942">Add Farm</h2>
        
      <label >Name of the farm</label>
      <input type="text" id="Name" name="Name" required>

    </div>
    <div class="form-grouppp">
        <label>Image</label>
        <input type="file" id="Image" name="Image" accept="image/*" required>
        
      </div>
      <div class="form-grouppp">
        <label>Description</label>
        <input type="text" id="Description" name="Description" required>

        </div>
        <div class="form-grouppp">
        <label>Address</label>
        <input type="text" id="Address" name="Address" required>
        
      </div>

      <div class="form-grouppp">
        <label>Activities</label>
        <input type="text" id="Activities" name="Activities" required>
        
      </div>
      <div class="form-grouppp">
        <label>Schedule</label>
        <input type="text" id="Schedule" name="Schedule" required>
        
      </div>
    <div class="form-grouppp">
      <label>Charges</label>
      <input type="text" id="Charges" name="Charges" required>
      
    </div>
    <div class="form-grouppp">
        <label>Contact info</label>
        <input type="text" id="Contact" name="Contact" required>
        
      </div>
      
    <button type="submit" style="border-radius: 40px;background-color: #4F7942;color: white;height: max-content;">ADD</button>
    
  </form>
  <?php if (isset($_SESSION['error'])): ?>
            <p style="color: red;"><?php echo htmlspecialchars($_SESSION['error']); ?></p>
            <?php unset($_SESSION['error']); // Clear the error message after displaying it ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <p style="color: blue;"><?php echo htmlspecialchars($_SESSION['success']); ?></p>
            <?php unset($_SESSION['success']); // Clear the success message after displaying it ?>
        <?php endif; ?>
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