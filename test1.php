<?php
// Connect to database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'payroll_system';

$connection = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data from users table
$users_query = "SELECT * FROM employee";
$users_result = mysqli_query($connection, $users_query);

echo "<h2>Users</h2>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>First Name</th><th>Email</th></tr>";
while ($row = mysqli_fetch_assoc($users_result)) {
    echo "<tr><td>".$row['id']."</td><td>".$row['first_name']."</td><td>".$row['email']."</td></tr>";
}
echo "</table>";

// Fetch data from orders table
$orders_query = "SELECT * FROM attendance";
$orders_result = mysqli_query($connection, $orders_query);

echo "<h2>Orders</h2>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Employee ID</th><th>Number of Hour</th><th>Status</th></tr>";
while ($row = mysqli_fetch_assoc($orders_result)) {
    echo "<tr><td>".$row['id']."</td><td>".$row['Employee_No']."</td><td>".$row['num_hr']."</td><td>".$row['status']."</td></tr>";
}
echo "</table>";

// Close connection
mysqli_close($connection);
?>
