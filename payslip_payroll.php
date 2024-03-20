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

// SQL query to fetch attendance data with INNER JOIN
$sql = "SELECT attendance.*, employee.*, position.*, employee.first_name
        FROM attendance 
        INNER JOIN employee ON attendance.Employee_No = employee.Employee_No
        LEFT JOIN position ON position.position = employee.position";





$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    </style>
</head>
<body>

<h2>Attendance Table</h2>

<table>
    <tr>
        <th>Date</th>
        <th>Employee Name</th>
        <th>Position</th>
        <th>Rate</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["date"]. "</td>";
            echo "<td>" . $row["first_name"].$row["last_name"]. "</td>";
            echo "<td>" . $row["position"]. "</td>";
            echo "<td>" . $row["rate"]. "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>0 results</td></tr>";
    }
    ?>
</table>

<?php
$conn->close();
?>

</body>
</html>
