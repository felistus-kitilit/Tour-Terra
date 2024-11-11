<?php
session_start(); // Start the session
$conn = mysqli_connect("localhost", "root", "", "tourterra");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$search = $_POST['search'];

// Prepare a variable to hold the search conditions
$searchConditions = array();

// Query the column names from the information_schema
$columnsQuery = "SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_NAME = 'farms' AND TABLE_SCHEMA = 'tourterra'";
$columnsResult = mysqli_query($conn, $columnsQuery);

// Loop through each column to add a LIKE condition to the searchConditions array
while ($column = mysqli_fetch_assoc($columnsResult)) {
    $searchConditions[] = $column['COLUMN_NAME'] . " LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
}

// Combine the search conditions with OR
$searchQuery = implode(" OR ", $searchConditions);

// Prepare the SQL query with the search conditions
$stmt = $conn->prepare("SELECT * FROM farms WHERE " . $searchQuery);
$stmt->execute();
$result = $stmt->get_result();

// Fetch and display the results
if ($result->num_rows > 0) {
    $farms = array();
    $farms = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($farms as $farm) {
        $_SESSION['Farmer'] = $farm['Farmer'];
        $_SESSION['FarmName'] = $farm['Name'];
        // If you want to store only the first farmer and farm name, you can break the loop here
        break;
    }
} else {
    $_SESSION['error'] = "no results found!!";
    header("Location: error.php");
    exit;
}

// Function to calculate the percentage of likes and the total number of ratings for a farm
function calculateRatingInfo($farmName, $conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS total_ratings, SUM(Rating = 1) AS likes FROM ratings WHERE FarmName = ?");
    $stmt->bind_param("s", $farmName);
    $stmt->execute();
    $result = $stmt->get_result();
    $ratingInfo = $result->fetch_assoc();
    $stmt->close(); // Close the statement here
    return $ratingInfo;
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="CSS/stylesheet.css" rel="stylesheet" />
    <link href="CSS/style.css" rel="stylesheet" />
    <link href="CSS/style1.css" rel="stylesheet" />
    <title>searched farms</title>
</head>
<body>
    <div id="logo">
        <img src="Images/TourLogo.png" style="padding-left: 750px;padding-right: 500px; height:100px; width:110px;padding-top: 20px;padding-bottom: 0px;" />
        <img src="Images/name.png" style="padding-left: 725px;padding-right: 500px;" />
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
        
        <?php if (isset($_SESSION['error'])): ?>
            <p style="color: blue;"><?php echo htmlspecialchars($_SESSION['error']); ?></p>
            <?php unset($_SESSION['error']); // Clear the error message after displaying it ?>        
        <?php endif; ?>
        
        <div class="login-formmmm">
            <form action="searched.php" method="post">
                Search: <input type="text" name="search"><br>
                <input type="submit" value="Search" style="background-color:gray;color: white">
            </form>
            
            <?php foreach ($farms as $farm): ?>
                <?php 
                    $ratingInfo = calculateRatingInfo($farm['Name'], $conn);
                    $totalRatings = $ratingInfo['total_ratings'];
                    $likes = $ratingInfo['likes'];
                    $percentage = $totalRatings > 0 ? round(($likes / $totalRatings) * 100) : 0;
                ?>
                <form action="Book1.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="Name" value="<?php echo htmlspecialchars($farm['Name']); ?>">
                    <div class="form-groupppp">
                        <p style="height:40px">______________________________________________________________________________</p>
                        <div style="display: inline-block; border-radius: 50px; background-color: #dddddd; padding: 5px 10px;">
                            <!-- Display the like image -->

                                <img src="Images/like.png" alt="Like" style="height: 20px; width: 20px;">
                            
                            <!-- Display the percentage and total number of ratings in brackets -->
                            <?php echo "$percentage%, ($totalRatings ratings)"; ?>
                        </div>
                        <br/><br/>
                        
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($farm['Name']); ?>" readonly>
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" readonly><?php echo htmlspecialchars($farm['Description']); ?></textarea> <br />
                        <label for="image">Image:</label><br />
                        <img src="uploads/<?php echo htmlspecialchars($farm['Image']); ?>" alt="Farm Image" style="max-width: 200px; max-height: 200px;"> <br />
                        <label for="Address">Address:</label>
                        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($farm['Address']); ?>" readonly>
                        <label for="activities">Activities:</label>
                        <input type="text" id="activities" name="activities" value="<?php echo htmlspecialchars($farm['Activities']); ?>"readonly>
                        <label for="schedule">Schedule:</label>
                        <input type="text" id="schedule" name="schedule" value="<?php echo htmlspecialchars($farm['Schedule']); ?>"readonly>
                        <label for="charges">Charges:</label>
                        <input type="text" id="charges" name="charges" value="<?php echo htmlspecialchars($farm['Charges']); ?>"readonly>
                        <label for="contact">Contact:</label>
                        <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($farm['Contact']); ?>"readonly>
                    </div>
                    <input type="submit" value="Book" style="border-radius: 40px;background-color: #4F7942;color: white">
                </form>
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
