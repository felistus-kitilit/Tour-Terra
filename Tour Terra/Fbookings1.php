<?php
session_start(); // Start the session
$conn = mysqli_connect("localhost", "root", "", "tourterra");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$Farmer = $_SESSION['UserName'];


$stmt = $conn->prepare("SELECT * FROM bookings WHERE Farmer = ? ORDER BY BookingID DESC");
$stmt->bind_param("s", $Farmer);
$stmt->execute();
$result = $stmt->get_result();

$bookings = array();

// Check if the query returned any rows
if ($result->num_rows > 0) {
    // Store the farms in an array for use in FEdit1.php
    $bookings = $result->fetch_all(MYSQLI_ASSOC);
}

// Close the statement
$stmt->close();
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="CSS/stylesheet.css" rel="stylesheet" />
    <link href="CSS/style.css" rel="stylesheet" />
    <link href="CSS/style1.css" rel="stylesheet" />
    
</head>
<title>Farmer Profile</title>
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
        <?php foreach ($bookings as $booking): ?>
            <form action="Fbookings.php" method="post" enctype="multipart/form-data">
            <input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($booking['BookingID']); ?>" >
                <div class="form-grouppp">
                <p style="height:40px">______________________________________________________________________________</p>
                    <label type="" for="FarmName" style="text-align:center; display:block; margin:auto;"> <?php echo htmlspecialchars($booking['FarmName']); ?> </label><br/>
                    <label for="FullName">FullName:</label>
                    <input type="text" id="FullName" name="FullName" value="<?php echo htmlspecialchars($booking['FullName']); ?>" readonly>
                    <label for="Email">Email Address:</label>
                    <textarea id="Email" name="Email" readonly><?php echo htmlspecialchars($booking['Email']); ?></textarea> <br />
                    <label for="Phone">Phone Number:</label>
                    <input type="number" id="Phone" name="Phone" value="<?php echo htmlspecialchars($booking['Phone']); ?>" readonly>
                    <label for="People">Number Of People:</label>
                    <input type="number" id="People" name="People" value="<?php echo htmlspecialchars($booking['People']); ?>" readonly>
                    <label for="Date">Date:</label>
                    <input type="text" id="Date" name="Date" value="<?php echo htmlspecialchars($booking['Date']); ?>" readonly>
                    <label for="Status">Status:</label>
                    <input type="text" id="Status" name="Status" value="<?php echo htmlspecialchars($booking['Status']); ?>" readonly>


                </div>
                <?php if ($booking['Status'] == 'pending'): ?>
                    <button type="submit" name="action" value="Accept" style="background-color:#4F7942;color:white" onclick="return confirm('Are you sure you want to Accept this booking?');">Accept</button>
                    <button type="submit" name="action" value="Decline" style="background-color:maroon;color:white" onclick="return confirm('Are you sure you want to Decline this booking?');">Decline</button>
                <?php endif; ?>
            </form>
            <?php if (isset($_SESSION['name2']) && $_SESSION['name2'] == $booking['BookingID'] && isset($_SESSION['success'])): ?>
        <p style="color: blue;"><?php echo htmlspecialchars($_SESSION['success']); ?></p>
        <?php unset($_SESSION['success']);// Clear the success message after displaying it ?>        
    <?php endif; ?>
        <?php endforeach; ?>  
        
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