
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
    .hide-id {
        display: none;
    }

    @media (max-width: 575.98px) {
            .hide-sm {
                display: none !important;
            }
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
                <h2> Employee Attendance </h2>
            </div>
            <div class="card bg-light" style="border-color: transparent;">
                <div class="card-body bg-light">
                    <!-- <button type="button" class="btn btn-primary float-left" data-toggle="modal" data-target="#studentaddmodal">
                        ADD DATA
                    </button> -->
                    
                    <input type="text" class="float-right" id="searchInput" placeholder="Search...">
                    <a class="btn btn-primary float-left" href="generate_pdf_employees_attendance.php" download>Download PDF</a>
                </div>
            </div>

            <div class="card bg-light" style="border-color: transparent;">
                <div class="card-body">

                    <?php

                    
                $connection = mysqli_connect("localhost","root","");
                $db = mysqli_select_db($connection, 'payroll_system');

                
                $query = "SELECT * FROM attendance";
                $query_run = mysqli_query($connection, $query);
            ?>
                    <table id="datatableid" class="table table-bordered shadow">
                        <thead>
                            <tr>
                                <th scope="col">Employee ID</th>
                                <th scope="col" class="hide-sm">TIME IN AM</th>
                                <th scope="col" class="hide-sm">TIME OUT AM</th>
                                <th scope="col" class="hide-sm">TIME IN PM</th>
                                <th scope="col" class="hide-sm">TIME OUT PM</th>
                                <th scope="col">NUMBER OF HOURS</th>
                                <th scope="col">STATUS</th>
                                <th scope="col">APROVAL</th>
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
                                                                                <?php
                                                // Assuming $row is the array containing time values

                                                // Check if all time values are empty or null
                                                if (empty($row['time_in']) && empty($row['time_out']) && empty($row['time_in2']) && empty($row['time_out2'])) {
                                                    echo "<td colspan='4'>No records Yet</td>";
                                                } else {
                                                    // If at least one time value is not empty or null, print the time values
                                                    ?>
                                                    <td> <?php echo !empty($row['time_in']) ? date('h:i A', strtotime($row['time_in'])) : ''; ?> </td>
                                                    <td> <?php echo !empty($row['time_out']) ? date('h:i A', strtotime($row['time_out'])) : ''; ?> </td>
                                                    <td> <?php echo !empty($row['time_in2']) ? date('h:i A', strtotime($row['time_in2'])) : ''; ?> </td>
                                                    <td> <?php echo !empty($row['time_out2']) ? date('h:i A', strtotime($row['time_out2'])) : ''; ?> </td>
                                                    <?php
                                                }
                                                ?>

                                <td><?php echo $row['num_hr'] - 1; ?></td>
                                <td> <?php echo $row['status']; ?> </td>
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
                </div>
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
                $('#admin_approve').val(data[9]);
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