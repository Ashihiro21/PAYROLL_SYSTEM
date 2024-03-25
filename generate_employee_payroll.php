<?php

session_start();

// Check if email is set in session
if (!isset($_SESSION['email'])) {
    // Handle the case where email is not set
    echo "Email is not set in session.";
    exit;
}

require_once('TCPDF-main/tcpdf.php');

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Employee Payslip');
$pdf->SetSubject('Payslip for Employees');
$pdf->SetKeywords('PDF, PHP, TCPDF, MySQL');

// Remove header and footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Add a page
$pdf->AddPage();

// Styles for table
$html = '<style>
            body { font-family: Arial, sans-serif; }
            table { width: 100%; border-collapse: collapse; }
            th, td { border: 2px solid #000; padding: 8px; font-size: 10px; }
            th { background-color: #f2f2f2; }
            td { text-align: center; }
            h1 { text-align: center; margin-bottom: 20px; }
            .empty-row { border: none; } /* Define CSS for empty rows */
        </style>';   

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


$email = mysqli_real_escape_string($conn, $_SESSION['email']);

// Query to get attendance information
$sql = "
SELECT 
    employee.Employee_No,
    CONCAT(employee.first_name, ' ', employee.last_name) AS full_name,
    COALESCE(total_hours.total_hours, 0) AS total_hours,
    position.rate AS position_rate,
    COALESCE(total_overtime.total_overtime, 0) AS total_overtime,
    COUNT(DISTINCT employee_leaves.leave_type) AS leave_count
FROM 
    employee
LEFT JOIN 
    attendance ON employee.Employee_No = attendance.Employee_No
LEFT JOIN 
    position ON employee.position_id = position.id
LEFT JOIN 
    employee_leaves ON employee.Employee_No = employee_leaves.Employee_No AND employee_leaves.status = 'Approve'
LEFT JOIN
    (SELECT 
        Employee_No,
        SUM(num_hr - 1) AS total_hours
    FROM 
        attendance
    WHERE 
        MONTH(date) = MONTH(CURDATE())
    GROUP BY 
        Employee_No) AS total_hours ON employee.Employee_No = total_hours.Employee_No
LEFT JOIN
    (SELECT 
        Employee_No,
        SUM(num_hr - 9) AS total_overtime
    FROM 
        attendance
    WHERE 
        MONTH(date) = MONTH(CURDATE())
    GROUP BY 
        Employee_No) AS total_overtime ON employee.Employee_No = total_overtime.Employee_No
WHERE 
    employee.email = '$email' AND  MONTH(attendance.date) = MONTH(CURDATE())
GROUP BY 
    employee.Employee_No, full_name, position_rate;
";


$result = $conn->query($sql);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}



$html .= '<h1>Employee Payslip</h1>';


$html .= '<table style="font-size: 16px;">';

if ($result->num_rows > 0) {
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
        
    
        $gross = $attendanceDays * $row['position_rate'];

        $net = ($row['leave_count'] * $row['position_rate']) + $gross - $deduction;
       
       
        $html .= '<tr><td colspan="2" style="font-size: 20px; text-align:center;"><b>Employee Details</b></td></tr>';
        $html .= '<tr><td style="font-size: 18px;">Full Name:</td><td style="font-size: 18px;">' . $row['full_name'] . '</td></tr>';
        $html .= '<tr><td style="font-size: 18px;">Employee No:</td><td style="font-size: 18px;">' . $row['Employee_No'] . '</td></tr>';
        $html .= '<tr><td colspan="2">&nbsp;</td></tr>'; // Empty row for space
        $html .= '<tr><td colspan="2" style="font-size: 20px;"><b>Hours</b></td></tr>';
        $html .= '<tr><td style="font-size: 18px;">Total Hours:</td><td style="font-size: 18px;">' . ($row['total_hours'] < 1 ? "0" : $row['total_hours']) . '</td></tr>'; 
        // $html .= '<tr><td style="font-size: 18px;">Position Rate:</td><td style="font-size: 18px;">' . $row['position_rate'] . '</td></tr>';
        // $html .= '<tr><td style="font-size: 18px;">Deduction:</td><td style="font-size: 18px;">' . $deduction . '</td></tr>';
        // $html .= '<tr><td style="font-size: 18px;">Gross Pay:</td><td style="font-size: 18px;">' . number_format($gross, 2) . '</td></tr>';
        $html .= '<tr><td style="font-size: 18px;">Overtime:</td><td style="font-size: 18px;">' . ($row['total_overtime'] < 1 ? "0" : $row['total_overtime']) . '</td></tr>';
        $html .= '<tr><td style="font-size: 18px;">Leave Count:</td><td style="font-size: 18px;">' . $row['leave_count'] . '</td></tr>';
        $html .= '<tr><td colspan="2">&nbsp;</td></tr>'; // Empty row for space
        // $html .= '<tr><td colspan="2" style="font-size: 20px;"><b>Net Pay</b></td></tr>';
        // $html .= '<tr><td style="font-size: 18px;">Net Pay:</td><td style="font-size: 18px;">' . number_format($net < 0 ? 0 : $net, 2) . '</td></tr><br/><br/>';
      
        
    
    }
} else {
    $html .= '<tr><td colspan="9">0 results</td></tr>';
}
$html .= '</table>';


// Print content into PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Close database connection
$conn->close();

// Close and output PDF
$pdf->Output('employees_payslip.pdf', 'D');

// Function to calculate attendance days
function calculateAttendanceDays($startDate, $endDate)
{
    $startDateTime = new DateTime($startDate);
    $endDateTime = new DateTime($endDate);
    $interval = $startDateTime->diff($endDateTime);
    $attendanceDays = $interval->days;
    return $attendanceDays;
}

?>
