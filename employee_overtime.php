
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
    .hide-id {
        display: none;
    }
    .searchbar{
    margin-bottom: auto;
    margin-top: auto;
    height: 60px;
    background-color: #353b48;
    border-radius: 30px;
    padding: 10px;
    color:white;
    }

    .search_input{
    color: white;
    border: 0;
    outline: 0;
    background: none;
    width: 0;
    caret-color:transparent;
    line-height: 40px;
    transition: width 0.4s linear;
    }

    .searchbar:hover > .search_input{
    padding: 0 10px;
    width: 250px;
    caret-color:red;
    transition: width 0.4s linear;
    }

    .searchbar:hover > .search_icon{
    background: white;
    color: #e74c3c;
    }

    .search_icon{
    height: 40px;
    width: 40px;
    float: right;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    color:white;
    text-decoration:none;
    }

    table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Define styles for responsive and scrollable table */
        .table-wrapper {
            overflow-x: auto;
        }

        /* Optional: Add max-width to prevent horizontal scrolling on smaller screens */
        .table-wrapper table {
            max-width: 100%;
        }

        h2{
            margin-bottom:2rem;
            margin-top:2rem;
        }
</style>
<body>

    <!-- Modal -->
    <div class="modal fade" id="studentaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
    </div>

    <!-- EDIT POP UP FORM (Bootstrap MODAL) -->
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Edit Employee Data </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="updatecode_attendance.php" method="POST">

                    <div class="modal-body">

                        <input type="hidden" name="update_id" id="update_id">

                                       
                        <div class="form-group">
                        <label for="admin_approve">Admin Approve</label>
                        <select name="admin_approve" id="admin_approve" class="form-control">
                            <option value="Pending">Pending</option>
                            <option value="Reject">Reject</option>
                            <option value="Approve">Approve</option>
        
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

                <form action="deletecode_attendance.php" method="POST">

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
                <h2> Overtime</h2>
            </div>
            <div class="card bg-light" style="border-color: transparent;">
                <div class="card-body bg-light">
                    <!-- <button type="button" class="btn btn-primary float-left" data-toggle="modal" data-target="#studentaddmodal">
                        ADD DATA
                    </button> -->
                    <div class="d-flex justify-content float-right  h-100">
                        <div class="searchbar">
                        <input class="search_input " type="text"  name=""  id="searchInput" placeholder="Search...">
                        <a href="#" class="search_icon"><i class="fas fa-search"></i></a>
                        </div>
                    </div>
                 
                    <a class="btn btn-primary float-left" href="generate_pdf_employees_overtime.php" download>Download PDF</a>
                </div>
            </div>

            <div class="card bg-light" style="border-color: transparent;">
                <div class="card-body">
<?php
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
        
            $result_count = mysqli_query($connection, "SELECT COUNT(*) AS total_records 
                                           FROM attendance WHERE num_hr > 8 AND date = CURDATE()");

  

            $total_records = mysqli_fetch_array($result_count);
            $total_records = $total_records['total_records'];
            $total_no_of_pages = ceil($total_records / $total_records_per_page);
            $second_last = $total_no_of_pages - 1; // total page minus 1

        
           


            $query = "SELECT * FROM attendance 
            WHERE overtime AND num_hr > 8 AND date = CURDATE()
            ORDER BY id DESC 
            LIMIT $offset, $total_records_per_page";
  
      
                $query_run = mysqli_query($connection, $query)
            ?>
              <div class="table-wrapper">
                    <table id="datatableid" class="table table-bordered shadow">
                        <thead>
                            <tr>
                                <th scope="col">Employee ID</th>
                                <th scope="col">Date</th>
                                <th scope="col">Overtime Hours</th>
                                <!-- <th scope="col">Status</th> -->
                                <th scope="col">Admin Approve</th>
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
                                <td> <?php echo $row['date']; ?> </td>
                                <td> <?php echo $row['num_hr'] - 9; ?> </td>
                                <td> <?php echo $row['admin_approve']; ?> </td>
                                
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
                    <div>
                </div>
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
<li class="page-item <?php if($page_no >= $total_no_of_pages) echo 'disabled'; ?>">
    <a class="page-link" <?php if($page_no < $total_no_of_pages) echo "href='nav.php?page=employee.php&page_no=$next_page'"; ?>>Next</a>
</li>

<!-- Last Page -->
<?php if($page_no < $total_no_of_pages) {
    echo "<li class='page-item'><a class='page-link' href='nav.php?page=employee.php&page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
} ?>
</ul>



<strong>Page <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
                </div>

        </div>
    </div>

               
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
                $('#description').val(data[1]);
                $('#amount').val(data[2]);
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