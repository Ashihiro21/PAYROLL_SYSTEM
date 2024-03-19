<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Position Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <style>
        .hide-id {
            display: none;
        }
    </style>
</head>

<body>

    <!-- Modal for Adding Data -->
    <div class="modal fade" id="studentaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <!-- Your Add Data modal content here -->
    </div>

    <!-- Modal for Editing Data -->
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <!-- Your Edit Data modal content here -->
    </div>

    <!-- Modal for Deleting Data -->
    <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <!-- Your Delete Data modal content here -->
    </div>

    <div class="container-fluid">
        <div class="jumbotron bg-light shadow border border-secondary">
            <div class="card bg-light" style="border-color: transparent;">
                <h2> Position </h2>
            </div>
            <div class="card bg-light" style="border-color: transparent;">
                <div class="card-body bg-light">
                    <input type="text" class="float-right" id="searchInput" placeholder="Search...">
                    <button type="button" class="btn btn-primary float-left" data-toggle="modal"
                        data-target="#studentaddmodal">
                        ADD DATA
                    </button>
                </div>
            </div>

            <div class="card bg-light" style="border-color: transparent;">
                <div class="card-body">
                    <table id="datatableid" class="table table-bordered shadow">
                        <thead>
                            <tr>
                                <th scope="col">Position</th>
                                <th scope="col">Rate</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <!-- Data rows will be loaded here dynamically -->
                        </tbody>
                    </table>
                    <!-- Pagination links will be loaded here dynamically -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {

            // Fetch and display data
            function fetchData() {
                $.ajax({
                    url: 'fetch_data.php', // Path to your PHP script for fetching data
                    type: 'GET',
                    success: function (response) {
                        $('#tableBody').html(response);
                    }
                });
            }

            fetchData(); // Initial data fetch

            // Initialize DataTable
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

            // Live search functionality
            $("#searchInput").on("keyup", function () {
                var value = $(this).val().toLowerCase();
                $("#tableBody tr").filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // Add your code for edit and delete modals, as well as their respective actions here

        });
    </script>
    <script>
        $(document).ready(function () {
    // Fetch and display data
    function fetchData(pageNumber = 1) {
        $.ajax({
            url: 'fetch_data.php',
            type: 'GET',
            data: { page: pageNumber },
            success: function (response) {
                $('#tableBody').html(response);
            }
        });
    }
    <?php
// Include database connection
include_once('db_config.php');

// Define number of records per page
$recordsPerPage = 10;

// Get current page number from the request, default to 1 if not set
$pageNumber = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate the offset for pagination
$offset = ($pageNumber - 1) * $recordsPerPage;

// Prepare SQL statement with pagination
$sql = "SELECT * FROM your_table LIMIT :offset, :limit";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
$stmt->execute();

// Fetch data
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output data as HTML table rows
foreach ($rows as $row) {
    echo "<tr>";
    echo "<td>{$row['position']}</td>";
    echo "<td>{$row['rate']}</td>";
    echo "<td>Action buttons here</td>";
    echo "</tr>";
}

// Close statement and connection
$stmt->closeCursor();
$conn = null;
?>


    fetchData(); // Initial data fetch

    // Initialize DataTable
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

    // Live search functionality
    $("#searchInput").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#tableBody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // Pagination click event
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        var pageNumber = $(this).attr('data-page');
        fetchData(pageNumber);
    });

    // Add your code for edit and delete modals, as well as their respective actions here

});
    </script>
</body>

</html>
