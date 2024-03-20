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

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prevent SQL injection by using prepared statements
    $employeeNo = $_POST["Employee_No"];
    $logType = $_POST["log_type"];
    $time = $_POST["time"];
    $location = $_POST["location"]; // New field: location

    $time = date("H:i", strtotime($time));

     // Check if the employee exists
     $check_query = "SELECT * FROM employee WHERE Employee_No = ?";
     $check_stmt = $conn->prepare($check_query);
     $check_stmt->bind_param("s", $employeeNo);
     $check_stmt->execute();
     $result = $check_stmt->get_result();
 
     if ($result->num_rows == 0) {
         session_start();
         $_SESSION['error_message'] = "Employee not registered.";
         header("Location: attendance_employee.php"); // Redirect to another page with error message
         exit();
     }

    // Prepare SQL statement based on the log type
    if ($logType == "time_in") {
        $sql = "INSERT INTO attendance (Employee_No, time_in, location, status, admin_approve) VALUES (?, ?, ?, 'waiting', 'pending')";

    } elseif ($logType == "time_out") {
        // Update query corrected
        $sql = "UPDATE attendance 
        SET 
        location = ?,  time_out = ?, 
            num_hr = time_out - time_in, 
            status = CASE 
                        WHEN time_out - time_in >= 10 THEN 'overtime' 
                        WHEN time_out - time_in >= 9 AND time_out - time_in <= 10 THEN 'regular'                     
                        WHEN time_out - time_in <= 8 THEN 'undertime'                     
                     END
        WHERE Employee_No=? AND date = CURDATE()";

    } elseif ($logType == "time_in2") {
        // Update query corrected
        $sql = "UPDATE attendance 
        SET 
            location = ?,  time_in2 = ?, 
            num_hr = time_in2 - time_in, 
            status = CASE 
                        WHEN time_in2 -  time_in >= 10 THEN 'overtime' 
                        WHEN time_in2 -  time_in >= 9 AND time_in2 -  time_in <=10 THEN 'regular' 
                        WHEN time_in2 -  time_in > 0 AND time_in2 -  time_in <=8 THEN 'undertime' 
                     END
        WHERE Employee_No=? AND date = CURDATE()";


    } elseif ($logType == "overtime") {
        // Update query corrected
        $sql = "UPDATE attendance 
        SET 
        location = ?,  overtime = ?, 
            num_hr = overtime - time_in, 
            status = CASE 
                        WHEN overtime - time_in >= 10 THEN 'overtime'                     
                     END
        WHERE Employee_No=? AND date = CURDATE()";

    } elseif ($logType == "time_out2") {
        // Update query corrected
        $sql = "UPDATE attendance 
        SET 
        location = ?,  time_out2 = ?, 
            num_hr = time_out2 - time_in, 
            status = CASE 
                        WHEN time_out2 - time_in >= 10 THEN 'overtime' 
                        WHEN time_out2 - time_in >= 9 AND time_out2 - time_in <= 10 THEN 'regular'                     
                        WHEN time_out2 - time_in <= 8 THEN 'undertime'                     
                     END
        WHERE Employee_No=? AND date = CURDATE()";

    } else {
        // Handle invalid $logType here
    }
    
    

    // Prepare and bind parameters for execution
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Bind parameters
        if ($logType == "time_in") {
            $stmt->bind_param("sss", $employeeNo, $time, $location);
        } elseif ($logType == "time_out") {
            $stmt->bind_param("sss", $location, $time, $employeeNo);
        }elseif ($logType == "time_in2") {
            $stmt->bind_param("sss", $location, $time, $employeeNo);
        }elseif ($logType == "overtime") {
            $stmt->bind_param("sss", $location, $time, $employeeNo);
        }elseif ($logType == "time_out2") {
            $stmt->bind_param("sss", $location, $time, $employeeNo);
        }
        session_start();
        // Execute statement
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Record updated successfully";
            header("Location: attendance_employee.php"); // Redirect to another_page.php
            exit();
        } else {
            echo "Error executing statement: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "No data received from the form.";
}

$conn->close();
?>
