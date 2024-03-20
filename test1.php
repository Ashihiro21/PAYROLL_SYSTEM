<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "payroll_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get the row count from a table
$sql = "SELECT COUNT(*) AS count FROM attendance WHERE overtime";

// Execute query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the result
    $row = $result->fetch_assoc();
    // Output the row count
    echo "Total rows: " . $row["count"];
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>
