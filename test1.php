<?php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "payroll_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to calculate number of attendance days
function calculateAttendanceDays($startDate, $endDate) {
    // Convert date strings to DateTime objects
    $startDateTime = new DateTime($startDate);
    $endDateTime = new DateTime($endDate);
    
    // Calculate the difference in days
    $interval = $startDateTime->diff($endDateTime);
    
    // Add 1 to include both start and end dates
    $attendanceDays = $interval->days;
    
    return $attendanceDays;
}

// Retrieve attendance records from database
$sql = "SELECT 
MIN(date) AS start_date, 
MAX(date) AS end_date 
FROM 
attendance 
WHERE 
MONTH(date) = MONTH(CURRENT_DATE())";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of the single row
    $row = $result->fetch_assoc();
    
    // Calculate number of attendance days for the date range
    $attendanceDays = calculateAttendanceDays($row["start_date"], $row["end_date"]);
    echo "Number of Attendance Days: " . $attendanceDays . "<br>";
} else {
    echo "0 results";
}

// Close database connection
$conn->close();

?>
