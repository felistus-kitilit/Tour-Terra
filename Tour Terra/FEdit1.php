<?php
session_start(); // Start the session

$conn = mysqli_connect("localhost", "root", "", "tourterra");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$Farmer = $_SESSION['UserName'];

$stmt = $conn->prepare("SELECT * FROM farms WHERE Farmer = ?");
$stmt->bind_param("s", $Farmer);
$stmt->execute();
$result = $stmt->get_result();

$farms = array();

// Check if the query returned any rows
if ($result->num_rows > 0) {
    // Store the farms in an array for use in FEdit1.php
    $farms = $result->fetch_all(MYSQLI_ASSOC);
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
<title>Edit Farms</title>
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
        <?php foreach ($farms as $farm): ?>
            <form action="FEdit.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="Name" value="<?php echo htmlspecialchars($farm['Name']); ?>">
                <div class="form-grouppp">
                <p style="height:40px">______________________________________________________________________________</p>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($farm['Name']); ?>">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description"><?php echo htmlspecialchars($farm['Description']); ?></textarea> <br />
                    <label for="image">Image:</label>
                    <input type="file" id="imageName" name="image">
                    <img src="uploads/<?php echo htmlspecialchars($farm['Image']); ?>" alt="Farm Image" style="max-width: 200px; max-height: 200px;"> <br />
                    <label for="Address">Address:</label>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($farm['Address']); ?>">
                    <label for="activities">Activities:</label>
                    <input type="text" id="activities" name="activities" value="<?php echo htmlspecialchars($farm['Activities']); ?>">
                    <label for="schedule">Schedule:</label>
                    <input type="text" id="schedule" name="schedule" value="<?php echo htmlspecialchars($farm['Schedule']); ?>">
                    <label for="charges">Charges:</label>
                    <input type="text" id="charges" name="charges" value="<?php echo htmlspecialchars($farm['Charges']); ?>">
                    <label for="contact">Contact:</label>
                    <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($farm['Contact']); ?>">
                </div>
                <input type="submit" value="Save" style="border-radius: 40px;background-color: #4F7942;color: white">
                <a href="delete_farm.php?id=<?php echo $farm['Name']; ?>" onclick="return confirm('Are you sure you want to delete this farm?');">Delete Farm</a>
                
            </form>
            <?php if (isset($_SESSION['name1']) && $_SESSION['name1'] == $farm['Name'] && isset($_SESSION['success'])): ?>
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