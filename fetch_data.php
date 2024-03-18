<?php

$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'payroll_system');

$search_query = $_POST['search_query'];

$query = "SELECT * FROM attendance";
if (!empty($search_query)) {
    $query .= " WHERE Employee_No LIKE '%$search_query%' OR status LIKE '%$search_query%' OR admin_approve LIKE '%$search_query%'";
}

$query_run = mysqli_query($connection, $query);

if ($query_run) {
    foreach ($query_run as $row) {
        // Output table rows
        echo "<tr>";
        echo "<td>" . $row['Employee_No'] . "</td>";
        echo "<td class='hide-sm'>" . (!empty($row['time_in']) ? date('h:i A', strtotime($row['time_in'])) : '') . "</td>";
        echo "<td class='hide-sm'>" . (!empty($row['time_out']) ? date('h:i A', strtotime($row['time_out'])) : '') . "</td>";
        echo "<td class='hide-sm'>" . (!empty($row['time_in2']) ? date('h:i A', strtotime($row['time_in2'])) : '') . "</td>";
        echo "<td class='hide-sm'>" . (!empty($row['time_out2']) ? date('h:i A', strtotime($row['time_out2'])) : '') . "</td>";
        echo "<td>" . ($row['num_hr'] - 1) . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td>" . $row['admin_approve'] . "</td>";
        echo "<td>";
        echo "<button type='button' class='btn btn-success editbtn'><i class='lni lni-pencil'></i></button>";
        echo "<button type='button' class='btn btn-danger deletebtn'><i class='lni lni-trash-can'></i></button>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "No Record Found";
}

?>
