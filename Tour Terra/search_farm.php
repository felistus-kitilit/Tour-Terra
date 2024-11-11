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
    while ($row = $result->fetch_assoc()) {
        $farms = array();
        $farms = $result->fetch_all(MYSQLI_ASSOC);
        // Display the results
        //echo "Name: " . htmlspecialchars($row['Name']) . "<br>";
        //echo "Description: " . htmlspecialchars($row['Description']) . "<br>";
        // Add more fields as needed
    }
} else {
    echo "No results found.";
}

// Close the statement and connection
$stmt->close();
mysqli_close($conn);

//header("Location: Tfarms1.php");
    //exit;

?>