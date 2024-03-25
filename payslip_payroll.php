<?php

// Database connection parameters
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




// Query to get total deduction amount
$sql = "SELECT SUM(amount) as total_amount FROM deduction";
$query = $conn->query($sql);
$drow = $query->fetch_assoc();
$deduction = $drow['total_amount'];


// Query to get attendance information
$sql = "
SELECT 
    employee.Employee_No,
    CONCAT(employee.first_name, ' ', employee.last_name) AS full_name,
    attendance.date,
    COALESCE(total_hours.total_hours, 0) AS total_hours,
    COALESCE(total_overtime.total_overtime, 0) AS total_overtime,
    COUNT(DISTINCT employee_leaves.leave_type) AS leave_count
FROM 
    employee
LEFT JOIN 
    attendance ON employee.Employee_No = attendance.Employee_No
LEFT JOIN 
    employee_leaves ON employee.Employee_No = employee_leaves.Employee_No AND employee_leaves.status = 'Approve'
LEFT JOIN
    (SELECT 
        Employee_No,
        CASE WHEN SUM(num_hr) > 9 THEN SUM(num_hr - 1) ELSE 0 END AS total_hours
    FROM 
        attendance
    WHERE 
        MONTH(date) = MONTH(CURDATE())
    GROUP BY 
        Employee_No) AS total_hours ON employee.Employee_No = total_hours.Employee_No
LEFT JOIN
    (SELECT 
        Employee_No,
        CASE WHEN SUM(num_hr) > 9 THEN SUM(num_hr - 9) ELSE 0 END AS total_overtime
    FROM 
        attendance
    WHERE 
        MONTH(date) = MONTH(CURDATE())
    GROUP BY 
        Employee_No) AS total_overtime ON employee.Employee_No = total_overtime.Employee_No
WHERE 
    MONTH(attendance.date) = MONTH(CURDATE())
GROUP BY 
    employee.Employee_No, full_name;
";







        // $overtime = $drow['total_hours - '];

// $sql = "
// SELECT employee.*, position.*
// FROM employee
// INNER JOIN position ON employee.position_id = position.id
// ";


$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="styles.css">
    <title>Attendance Table</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Define styles for responsive and scrollable table */
        .table-wrapper {
            overflow-x: auto;
        }

        /* Optional: Add max-width to prevent horizontal scrolling on smaller screens */
        .table-wrapper table {
            max-width: 100%;
        }

        h2{
            margin-bottom:2rem;
            margin-top:2rem;
        }


    </style>
</head>
<body>

<a class="btn btn-primary float-left downloads" href="generate_payroll.php" download>Download PDF</a><br>
<h2>Payroll Table</h2>
<div class="table-wrapper">


<table class="table table-bordered shadow">
    <tr>
        <th>Employee Name</th>
        <th>Employee ID</th>
        <th>Number of Hours</th>
        <!-- <th>Rate</th> -->
        <!-- <th>Deduction</th> -->
        <!-- <th>Basic Salary</th> -->
        <th>Overtime</th>
        <th>Leaves</th>
        <!-- <th>Net</th> -->
    </tr>
    <?php


  // Define the calculateAttendanceDays function outside the loop
function calculateAttendanceDays($startDate, $endDate)
{
    // Convert date strings to DateTime objects
    $startDateTime = new DateTime($startDate);
    $endDateTime = new DateTime($endDate);

    // Calculate the difference in days
    $interval = $startDateTime->diff($endDateTime);

    // Add 1 to include both start and end dates
    $attendanceDays = $interval->days;

    return $attendanceDays;
}

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {

        $sqldate = "SELECT 
            MIN(date) AS start_date, 
            MAX(date) AS end_date 
        FROM 
            attendance
        WHERE 
            MONTH(date) = MONTH(CURRENT_DATE())";

        $datequery = $conn->query($sqldate);
        
        $carow = $datequery->fetch_assoc();

        $attendanceDays = calculateAttendanceDays($carow["start_date"], $carow["end_date"]);
        
        // Calculate gross
        // $gross = $attendanceDays * $row['position_rate'];

    
                
                
        // $net = ($row['leave_count'] * $row['position_rate']) + $gross - $deduction;


            echo "<tr>";
            echo "<td>" . $row['full_name'] . "</td>";
            echo "<td>" . $row['Employee_No'] . "</td>";
            echo "<td>" . ($row['total_hours'] < 0 ? 0 : $row['total_hours']) . "</td>";
            // echo "<td>" . $row['position_rate'] . "</td>";
            // echo "<td>" . $deduction . "</td>";
            // echo "<td>" . number_format($gross, 2) . "</td>";
            echo "<td>" . ($row['total_overtime'] < 0 ? 0 : $row['total_overtime']) . "</td>";
            echo "<td>" . $row['leave_count']. "</td>";
            // echo "<td>" . number_format($net < 0 ? 0 : $net, 2) . "</td>";   
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='2'>0 results</td></tr>";
    }
    ?>
</table>
</div>
<?php
$conn->close();
?>

</body>
</html>
