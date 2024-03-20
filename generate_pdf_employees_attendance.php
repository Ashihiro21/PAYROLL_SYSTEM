<?php
// Include the TCPDF library
require_once('TCPDF-main/tcpdf.php');

// Create new PDF document
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('User List PDF');
$pdf->SetSubject('List of Users from Database');
$pdf->SetKeywords('PDF, PHP, TCPDF, MySQL');

// Remove header and footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Add a page
$pdf->AddPage();

// Connect to your database (Replace with your own database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "payroll_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch users from the database
$sql = "SELECT A.Employee_No, A.time_in, A.time_out, A.time_in2, A.time_out2, A.date, A.num_hr, E.first_name, E.last_name
        FROM attendance A
        INNER JOIN employee E ON A.Employee_No = E.Employee_No";

$result = $conn->query($sql);

// Output data of each row
$html = '<style>
            table { width: 100%; border-collapse: collapse; }
            td { text-align: center; padding: 5px; font-size: 10px; padding: 10px; } /* Adjust font size */
            th { text-align: center; font-weight: bold; font-size: 12px; padding: 10px; } /* Adjust font size */
        </style>';
$html .= '<h1 style="text-align: center;">Employee Attendance</h1>';
$html .= '<table border="1">
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Time IN AM</th>
                <th>Time Out AM</th>
                <th>Time IN PM</th>
                <th>Time Out PM</th>
                <th>Number of Hours</th>
                <th>STATUS</th>
                <th>Date</th>
            </tr>';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // You may need to adjust the overtime calculation logic here
        $overtime_hours = $row["num_hr"] - 1; // Adjust as necessary

        $html .= '<tr>
                    <td>' . $row["Employee_No"] . '</td>
                    <td>' . $row["first_name"] . ' ' . $row["last_name"] . '</td>
                    <td>' . date('h:i A', strtotime($row["time_in"])) . '</td>
                    <td>' . date('h:i A', strtotime($row["time_out"])) . '</td>
                    <td>' . date('h:i A', strtotime($row["time_in2"])) . '</td>
                    <td>' . date('h:i A', strtotime($row["time_out2"])) . '</td>
                    <td>' . $overtime_hours . '</td>
                    <td>' . $row["status"] . '</td>
                    <td>' . $row["date"] . '</td>
                  </tr>';
    }
} else {
    $html .= '<tr><td colspan="4">No Employee Found</td></tr>';
}
$html .= '</table>';

// Print content into PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Close database connection
$conn->close();

// Close and output PDF
$pdf->Output('employees_attendance.pdf', 'D');
?>
