<?php


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

// Ensure session email is set
if(isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT COUNT(*) AS leave_count FROM employee_leaves WHERE email = ?");
    if ($stmt === false) {
        die('Error in preparing the SQL statement: ' . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result === false) {
        die('Error in executing the SQL statement: ' . $stmt->error);
    }

    // Fetch the row from the result
    $row = $result->fetch_assoc();

    // Get the leave count
    $leave_count = $row['leave_count'];
} else {
    // Redirect or handle error if session email is not set
    // For example:
    header("Location: login.php"); // Redirect to login page
    exit(); // Stop further execution
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Count</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
  div.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  text-align: center;
}
.btn{
        border: 1px solid gray;
    }
</style>


</head>

<body>
<div class="container-fluid mt-5">
        <div class="row">
    <div class="row">

        <!-- Employee Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Leaves</h5>
                    <p class="card-text"><?php echo "Number of Leaves: " . $leave_count; ?></p>
                    <a class="btn btn-primary shadow" href="employee_main.php?page=employee_leaves.php">Click This</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
