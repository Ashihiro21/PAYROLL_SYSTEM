<?php

// Function to populate leaves dropdown from the database
function populateleavesDropdown() {
    // Replace these database connection details with your own
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

    // SQL query to get leavess from the database (replace 'your_table_name' with the actual table name)
    $sql = "SELECT * FROM leaves";
    $result = $conn->query($sql);

    $options = "";

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $leave_type = $row["leave_type"];
            $options .= "<option value='$leave_type'>$leave_type</option>";
        }
    } else {
        $options .= "<option value=''>No leaves found</option>";
    }

    $conn->close();

    return $options;
}

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

$username = $_SESSION['email'];

$stmt = $conn->prepare("SELECT employee.*, attendance.*
FROM employee
LEFT JOIN attendance ON employee.Employee_No = attendance.Employee_No
WHERE employee.email = ?
");
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the row from the result
$row = $result->fetch_assoc();

// Store the values in variables
$employee_id = $row['Employee_No'];
$first_name = $row['first_name'];
$last_name = $row['last_name'];
$email = $row['email'];
?>


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
    .hide-id {
        display: none;
    }
</style>
<body>

    <!-- Modal -->
    <div class="modal fade" id="studentaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Leaves Data </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="insertcode_employee_leaves.php" method="POST">

                    <div class="modal-body">

                                        <div class="form-group">
                        <input type="hidden" name="Employee_No" class="form-control" placeholder="Enter Employee ID" value="<?php echo $employee_id; ?>">
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="first_name" class="form-control" placeholder="Enter first Name" value="<?php echo $first_name; ?>">
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="last_name" class="form-control" placeholder="Enter last_name" value="<?php echo $last_name; ?>">
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="email" class="form-control" placeholder="Enter email" value="<?php echo $email; ?>">
                    </div>

                    <div class="form-group">
                            <label> Leave Type </label>
                            <select name="leave_type" class="form-control">
                            <?php echo populateleavesDropdown(); ?>
                        </select>
                        </div>
                        <div class="form-group">
                            <label> Start Date </label>
                            <input type="date" name="start_date" class="form-control" placeholder="Enter Start Date">
                        </div>
                        <div class="form-group">
                            <label> End Date </label>
                            <input type="date" name="end_date" class="form-control" placeholder="Enter End Date">
                        </div>
                     
                        <div class="form-group">
                            <input type="hidden" name="status" class="form-control" value="Pending" placeholder="Enter Leave Type">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="insertdata" class="btn btn-primary">Save Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- EDIT POP UP FORM (Bootstrap MODAL) -->
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Edit Leaves Data </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="updatecode_employee_leaves.php" method="POST">

                    <div class="modal-body">

                        <input type="hidden" name="update_id" id="update_id">

                        <div class="form-group">
                            <label> Leave Type </label>
                            <select name="leave_type" class="form-control">
                            <?php echo populateleavesDropdown(); ?>
                        </select>
                        </div>

                        <div class="form-group">
                            <label> Start Date </label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                placeholder="Enter Start Date">
                        </div>

                        <div class="form-group">
                            <label> End Date </label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                placeholder="Enter Start Date">
                        </div>


                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="updatedata" class="btn btn-primary">Update Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- DELETE POP UP FORM (Bootstrap MODAL) -->
    <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Delete Student Data </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="deletecode_employee_leaves.php" method="POST">

                    <div class="modal-body">

                        <input type="hidden" name="delete_id" id="delete_id">

                        <h4> Do you want to Delete this Data ??</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> NO </button>
                        <button type="submit" name="deletedata" class="btn btn-primary"> Yes !! Delete it. </button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <!-- VIEW POP UP FORM (Bootstrap MODAL) -->
    <div class="modal fade" id="viewmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> View Student Data </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="deletecode_deduction.php" method="POST">

                    <div class="modal-body">

                        <input type="text" name="view_id" id="view_id">

                        <!-- <p id="decription"> </p> -->
                        <h4 id="decription"> <?php echo ''; ?> </h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> CLOSE </button>
                        <!-- <button type="submit" name="deletedata" class="btn btn-primary"> Yes !! Delete it. </button> -->
                    </div>
                </form>

            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="jumbotron bg-light shadow border border-secondary">
            <div class="card bg-light" style="border-color: transparent;">
                <h2> ATTENDANCE </h2>
            </div>
            <div class="card bg-light" style="border-color: transparent;">
                <div class="card-body bg-light">
                    <!-- <button type="button" class="btn btn-primary float-left" data-toggle="modal" data-target="#studentaddmodal">
                        ADD DATA
                    </button> -->
                </div>
            </div>

            <div class="card bg-light" style="border-color: transparent;">
                <div class="card-body">

                    <?php

                

                $connection = mysqli_connect("localhost","root","");
                $db = mysqli_select_db($connection, 'payroll_system');

                if (isset($_GET['page_no']) && $_GET['page_no']!="") {
                    $page_no = $_GET['page_no'];
                } else {
                    $page_no = 1;
                }
                
                $total_records_per_page = 5;
                $offset = ($page_no - 1) * $total_records_per_page;
                $previous_page = $page_no - 1;
                $next_page = $page_no + 1;
                $adjacents = 2;
                
                $result_count = mysqli_query($connection, "SELECT COUNT(*) As total_records FROM employee LEFT JOIN attendance ON employee.Employee_No = attendance.Employee_No WHERE employee.email = '$email'");

                $total_records = mysqli_fetch_array($result_count);
                $total_records = $total_records['total_records'];
                $total_no_of_pages = ceil($total_records / $total_records_per_page);
                $second_last = $total_no_of_pages - 1; // total page minus 1



                $email = mysqli_real_escape_string($connection, $_SESSION['email']);

                $query = "SELECT employee.*, attendance.*
                FROM employee
                LEFT JOIN attendance ON employee.Employee_No = attendance.Employee_No
                WHERE employee.email = '$email' ORDER BY employee.id DESC
                LIMIT $offset, $total_records_per_page;
                ";


                $query_run = mysqli_query($connection, $query);
            ?>
                    <table id="datatableid" class="table table-bordered shadow">
                        <thead>
                            <tr>
                                <th scope="col">TIME IN AM</th>
                                <th scope="col">TIME IN OUT AM</th>
                                <th scope="col">TIME IN PM</th>
                                <th scope="col">TIME IN OUT PM</th>
                                <th scope="col">Number of Hours</th>
                                <th scope="col">Admin Approval</th>
                                <th scope="col">DATE</th>
                            </tr>
                        </thead>
                        <?php
                if($query_run)
                {
                    foreach($query_run as $row)
                    {
            ?>
                        <tbody>
                            <tr>
                                <td class="hide-id"> <?php echo $row['id']; ?> </td>
                                <td class="hide-id"> <?php echo $row['email']; ?> </td>
                                <td> <?php echo !empty($row['time_in']) ? date('h:i A', strtotime($row['time_in'])) : 'No Time in'; ?> </td>
                                <td> <?php echo !empty($row['time_out']) ? date('h:i A', strtotime($row['time_out'])) : 'No Time Out'; ?> </td>
                                <td> <?php echo !empty($row['time_in2']) ? date('h:i A', strtotime($row['time_in2'])) : 'No Time In'; ?> </td>
                                <td> <?php echo !empty($row['time_out2']) ? date('h:i A', strtotime($row['time_out2'])) : 'No Time Out'; ?> </td>
                                
                                <td><?php echo ($row['num_hr'] - 1) < 1 ? 0 : ($row['num_hr'] - 1); ?></td>
                                <td> <?php echo $row['admin_approve']; ?> </td>
                                <td> <?php echo $row['date']; ?> </td>
                                <!-- <td> -->
                                <!-- <button type="button" class="btn btn-info viewbtn"><i class="lni lni-eye"></i></button> -->

                                <!-- <button type="button" class="btn btn-success editbtn"><i class="lni lni-pencil"></i></button>

                                <button type="button" class="btn btn-danger deletebtn"><i class="lni lni-trash-can"></i></button> -->
                                <!-- </td> -->
                            </tr>
                        </tbody>
                        <?php           
                    }
                }
                else 
                {
                    
                    echo "No Record Found";
                }
            ?>
                    </table>
                </div>
            </div>


        </div>
    </div>


    <strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
                </div>

                <ul class="pagination">

<!-- First Page -->
<?php // if($page_no > 1){ echo "<li><a href='employee_main.php?page=employee_attendance.php&page_no=1'>First Page</a></li>"; } ?>

<!-- Previous Page -->
<li class="page-item <?php if($page_no <= 1) echo 'disabled'; ?>">
    <a class="page-link" <?php if($page_no > 1) echo "href='employee_main.php?page=employee_attendance.php&page_no=$previous_page'"; ?>>Previous</a>
</li>

<!-- Pagination Loop -->
<?php 
if ($total_no_of_pages <= 10) {  	 
    for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
        if ($counter == $page_no) {
            echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
        } else {
            echo "<li class='page-item'><a class='page-link' href='employee_main.php?page=employee_attendance.php&page_no=$counter'>$counter</a></li>";
        }
    }
} elseif ($total_no_of_pages > 10) {
    if ($page_no <= 4) {			
        for ($counter = 1; $counter < 8; $counter++) {		 
            if ($counter == $page_no) {
                echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
            } else {
                echo "<li class='page-item'><a class='page-link' href='employee_main.php?page=employee_attendance.php&page_no=$counter'>$counter</a></li>";
            }
        }
        echo "<li class='page-item'><a class='page-link'>...</a></li>";
        echo "<li class='page-item'><a class='page-link' href='employee_main.php?page=employee_attendance.php&page_no=$second_last'>$second_last</a></li>";
        echo "<li class='page-item'><a class='page-link' href='employee_main.php?page=employee_attendance.php&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
    } elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
        echo "<li class='page-item'><a class='page-link' href='employee_main.php?page=employee_attendance.php&page_no=1'>1</a></li>";
        echo "<li class='page-item'><a class='page-link' href='employee_main.php?page=employee_attendance.php&page_no=2'>2</a></li>";
        echo "<li class='page-item'><a class='page-link'>...</a></li>";
        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
            if ($counter == $page_no) {
                echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
            } else {
                echo "<li class='page-item'><a class='page-link' href='employee_main.php?page=employee_attendance.php&page_no=$counter'>$counter</a></li>";
            }                  
        }
        echo "<li class='page-item'><a class='page-link'>...</a></li>";
        echo "<li class='page-item'><a class='page-link' href='employee_main.php?page=employee_attendance.php&page_no=$second_last'>$second_last</a></li>";
        echo "<li class='page-item'><a class='page-link' href='employee_main.php?page=employee_attendance.php&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";      
    } else {
        echo "<li class='page-item'><a class='page-link' href='employee_main.php?page=employee_attendance.php&page_no=1'>1</a></li>";
        echo "<li class='page-item'><a class='page-link' href='employee_main.php?page=employee_attendance.php&page_no=2'>2</a></li>";
        echo "<li class='page-item'><a class='page-link'>...</a></li>";

        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
            if ($counter == $page_no) {
                echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
            } else {
                echo "<li class='page-item'><a class='page-link' href='employee_main.php?page=employee_attendance.php&page_no=$counter'>$counter</a></li>";
            }                   
        }
    }
}
?>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>


    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function () {

            $('.viewbtn').on('click', function () {
                $('#viewmodal').modal('show');
                $.ajax({ //create an ajax request to display.php
                    type: "GET",
                    url: "display.php",
                    dataType: "html", //expect html to be returned                
                    success: function (response) {
                        $("#responsecontainer").html(response);
                        //alert(response);
                    }
                });
            });

        });
    </script>


    <script>
        $(document).ready(function () {

            $('#datatableid').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search Your Data",
                }
            });

        });
    </script>

    <script>
        $(document).ready(function () {

            $('.deletebtn').on('click', function () {

                $('#deletemodal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#delete_id').val(data[0]);

            });
        });
    </script>

    <script>
        $(document).ready(function () {

            $('.editbtn').on('click', function () {

                $('#editmodal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#update_id').val(data[0]);
                $('#leave_type').val(data[5]);
                $('#start_date').val(data[6]);
                $('#end_date').val(data[7]);
            });
        });
    </script>

