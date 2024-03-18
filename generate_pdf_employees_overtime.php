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
$sql = "SELECT A.Employee_No, A.date, A.num_hr, E.first_name, E.last_name
        FROM attendance A
        INNER JOIN employee E ON A.Employee_No = E.Employee_No
        WHERE A.admin_approve = 'Approve' AND num_hr > 9;";

$result = $conn->query($sql);

// Output data of each row
$html = '<h1 style="text-align: center;">Employee Overtime</h1>';
$html .= '<table border="1" style="width: 100%; border-collapse: collapse;">
            <tr>
                <th style="text-align: center; padding: 10px; font-weight: bold;">Employee ID</th>
                <th style="text-align: center; padding: 10px; font-weight: bold;">Name</th>
                <th style="text-align: center; padding: 10px; font-weight: bold;">Number of Hours OT</th>
                <th style="text-align: center; padding: 10px; font-weight: bold;">Date</th>
            </tr>';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // You may need to adjust the overtime calculation logic here
        $overtime_hours = $row["num_hr"] - 9; // Adjust as necessary

        $html .= '<tr>
                    <td style="text-align: center; padding: 10px;">' . $row["Employee_No"] . '</td>
                    <td style="text-align: center; padding: 10px;">' . $row["first_name"] . ' ' . $row["last_name"] . '</td>
                    <td style="text-align: center; padding: 10px;">' . $overtime_hours . '</td>
                    <td style="text-align: center; padding: 10px;">' . $row["date"] . '</td>
                  </tr>';
    }
} else {
    $html .= '<tr><td colspan="4" style="text-align: center;">No Employee Found</td></tr>';
}
$html .= '</table>';

// Print content into PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Close database connection
$conn->close();

// Close and output PDF
$pdf->Output('employee_list_overtime.pdf', 'D');
?>
