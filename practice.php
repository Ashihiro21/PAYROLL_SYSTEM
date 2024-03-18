<?php
require_once('tcpdf/tcpdf.php');

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('User List PDF');
$pdf->SetSubject('List of Users from Database');
$pdf->SetKeywords('PDF, PHP, TCPDF, MySQL');

// Add a page
$pdf->AddPage();

// Connect to your database (Replace with your own database credentials)
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "database";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch users from the database
$sql = "SELECT id, name, email FROM users";
$result = $conn->query($sql);

// Output data of each row
$html = '<h1>User List</h1>';
$html .= '<table border="1"><tr><th>ID</th><th>Name</th><th>Email</th></tr>';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr><td>' . $row["id"] . '</td><td>' . $row["name"] . '</td><td>' . $row["email"] . '</td></tr>';
    }
    $html .= '</table>';
} else {
    $html .= '<tr><td colspan="3">No users found</td></tr>';
}
$html .= '</table>';

// Print content into PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Close database connection
$conn->close();

// Close and output PDF
$pdf->Output('user_list.pdf', 'D');
?>
