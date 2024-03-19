
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
    <!-- <div class="modal fade" id="studentaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Student Data </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="insertcode_deduction.php" method="POST">

                    <div class="modal-body">
                        <div class="form-group">
                            <label> description </label>
                            <input type="text" name="description" class="form-control" placeholder="Enter description">
                        </div>

                        <div class="form-group">
                            <label> Amount </label>
                            <input type="text" name="amount" class="form-control" placeholder="Enter Amount">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="insertdata" class="btn btn-primary">Save Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div> -->

  

    <!-- EDIT POP UP FORM (Bootstrap MODAL) -->
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Edit employee_leaves_display Data </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="updatecode_employee_leaves_display_leaves_display.php" method="POST">

                    <div class="modal-body">

                        <input type="hidden" name="update_id" id="update_id">

                        <div class="form-group">
                            <label> Status </label>
                            <select name="status" id="status" class="form-control">
                                <option value="Pending" selected>pending</option>
                                <option value="Approve">Approve</option>
                                <option value="Denied">Denied</option>
                            </select>


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

                <form action="deletecode_deduction.php" method="POST">

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
                <h2> employee_leaves_display Leaves </h2>
            </div>
            <div class="card bg-light" style="border-color: transparent;">
                <div class="card-body bg-light">
                    <!-- <button type="button" class="btn btn-primary float-left" data-toggle="modal" data-target="#studentaddmodal">
                        ADD DATA
                    </button> -->
                    <input type="text" class="float-right" id="searchInput" placeholder="Search...">
                    <a class="btn btn-primary float-left" href="generate_pdf_employee_leaves_displays_leaves.php" download>Download PDF</a>
                </div>
            </div>

            <div class="card bg-light" style="border-color: transparent;">
                <div class="card-body">

                    <?php
        
                     
           
               // Database connection
               
               $connection = mysqli_connect("localhost","root","","payroll_system");
                   if (mysqli_connect_errno()){
                       echo "Failed to connect to MySQL: " . mysqli_connect_error();
                       die();
                       }
               
               if (isset($_GET['page_no']) && $_GET['page_no']!="") {
                   $page_no = $_GET['page_no'];
                   } else {
                       $page_no = 1;
                       }
               
                   $total_records_per_page = 5;
                   $offset = ($page_no-1) * $total_records_per_page;
                   $previous_page = $page_no - 1;
                   $next_page = $page_no + 1;
                   $adjacents = "2"; 
               
                   $result_count = mysqli_query($connection,"SELECT COUNT(*) As total_records FROM employee_leaves");
                   $total_records = mysqli_fetch_array($result_count);
                   $total_records = $total_records['total_records'];
                   $total_no_of_pages = ceil($total_records / $total_records_per_page);
                   $second_last = $total_no_of_pages - 1; // total page minus 1

                   $query = "SELECT * FROM employee_leaves ORDER BY id DESC LIMIT $offset, $total_records_per_page";
                   $query_run = mysqli_query($connection, $query);
    
            ?>
                    <table id="datatableid" class="table table-bordered shadow">
                        <thead>
                            <tr>
                                <th scope="col">Employee ID</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Leave Type</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <?php
                if($query_run)
                {
                    foreach($query_run as $row)
                    {
            ?>
                        <tbody id="tableBody">
                            <tr>
                                <td class="hide-id"> <?php echo $row['id']; ?> </td>
                                <td> <?php echo $row['Employee_No']; ?> </td>
                                <td> <?php echo $row['first_name']; ?> </td>
                                <td> <?php echo $row['last_name']; ?> </td>
                                <td> <?php echo $row['leave_type']; ?> </td>
                                <td> <?php echo $row['start_date']; ?> </td>
                                <td> <?php echo $row['end_date']; ?> </td>
                                <td> <?php echo $row['status']; ?> </td>
                                <td>
                                <!-- <button type="button" class="btn btn-info viewbtn"><i class="lni lni-eye"></i></button> -->

                                <button type="button" class="btn btn-success editbtn"><i class="lni lni-pencil"></i></button>

                                <button type="button" class="btn btn-danger deletebtn"><i class="lni lni-trash-can"></i></button>
                                </td>
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
<?php // if($page_no > 1){ echo "<li><a href='nav.php?page=employee_leaves_display.php&page_no=1'>First Page</a></li>"; } ?>

<!-- Previous Page -->
<li class="page-item <?php if($page_no <= 1) echo 'disabled'; ?>">
    <a class="page-link" <?php if($page_no > 1) echo "href='nav.php?page=employee_leaves_display.php&page_no=$previous_page'"; ?>>Previous</a>
</li>

<!-- Pagination Loop -->
<?php 
if ($total_no_of_pages <= 10) {  	 
    for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
        if ($counter == $page_no) {
            echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
        } else {
            echo "<li class='page-item'><a class='page-link' href='nav.php?page=employee_leaves_display.php&page_no=$counter'>$counter</a></li>";
        }
    }
} elseif ($total_no_of_pages > 10) {
    if ($page_no <= 4) {			
        for ($counter = 1; $counter < 8; $counter++) {		 
            if ($counter == $page_no) {
                echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
            } else {
                echo "<li class='page-item'><a class='page-link' href='nav.php?page=employee_leaves_display.php&page_no=$counter'>$counter</a></li>";
            }
        }
        echo "<li class='page-item'><a class='page-link'>...</a></li>";
        echo "<li class='page-item'><a class='page-link' href='nav.php?page=employee_leaves_display.php&page_no=$second_last'>$second_last</a></li>";
        echo "<li class='page-item'><a class='page-link' href='nav.php?page=employee_leaves_display.php&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
    } elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
        echo "<li class='page-item'><a class='page-link' href='nav.php?page=employee_leaves_display.php&page_no=1'>1</a></li>";
        echo "<li class='page-item'><a class='page-link' href='nav.php?page=employee_leaves_display.php&page_no=2'>2</a></li>";
        echo "<li class='page-item'><a class='page-link'>...</a></li>";
        for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
            if ($counter == $page_no) {
                echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
            } else {
                echo "<li class='page-item'><a class='page-link' href='nav.php?page=employee_leaves_display.php&page_no=$counter'>$counter</a></li>";
            }                  
        }
        echo "<li class='page-item'><a class='page-link'>...</a></li>";
        echo "<li class='page-item'><a class='page-link' href='nav.php?page=employee_leaves_display.php&page_no=$second_last'>$second_last</a></li>";
        echo "<li class='page-item'><a class='page-link' href='nav.php?page=employee_leaves_display.php&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";      
    } else {
        echo "<li class='page-item'><a class='page-link' href='nav.php?page=employee_leaves_display.php&page_no=1'>1</a></li>";
        echo "<li class='page-item'><a class='page-link' href='nav.php?page=employee_leaves_display.php&page_no=2'>2</a></li>";
        echo "<li class='page-item'><a class='page-link'>...</a></li>";

        for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
            if ($counter == $page_no) {
                echo "<li class='page-item active'><a class='page-link'>$counter</a></li>";	
            } else {
                echo "<li class='page-item'><a class='page-link' href='nav.php?page=employee_leaves_display.php&page_no=$counter'>$counter</a></li>";
            }                   
        }
    }
}
?>

<!-- Next Page -->
<li class="page-item <?php if($page_no >= $total_no_of_pages) echo 'disabled'; ?>">
    <a class="page-link" <?php if($page_no < $total_no_of_pages) echo "href='nav.php?page=employee_leaves_display.php&page_no=$next_page'"; ?>>Next</a>
</li>

<!-- Last Page -->
<?php if($page_no < $total_no_of_pages) {
    echo "<li class='page-item'><a class='page-link' href='nav.php?page=employee_leaves_display.php&page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
} ?>
</ul>

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
                $('#description').val(data[7]);
            });
        });
    </script>

<script>
    $(document).ready(function(){
        // Live search functionality
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#tableBody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>