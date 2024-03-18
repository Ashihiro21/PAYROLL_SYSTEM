




<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="styles.css">

<style>
  div.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  text-align: center;
}
.btn{
        border: 1px solid gray;
    }
</style>


<h1>Dashboard</h1>

<div class="container-fluid">
  <div class="row">



  
  
    <?php
include_once("connection.php");

// Query to get the count of employees
$employeeQuery = "SELECT COUNT(*) as employeeCount FROM employee";
$employeeResult = $conn->query($employeeQuery);

// Query to get the count of deductions
$deductionQuery = "SELECT COUNT(*) as deductionCount FROM deduction";
$deductionResult = $conn->query($deductionQuery);

$holidayQuery = "SELECT COUNT(*) as holidayCount FROM holiday";
$holidayResult = $conn->query($holidayQuery);

// Query to get the count of schedules
$scheduleQuery = "SELECT COUNT(*) as scheduleCount FROM schedules";
$scheduleResult = $conn->query($scheduleQuery);

$positionQuery = "SELECT COUNT(*) as positionCount FROM position";
$positionResult = $conn->query($positionQuery);

if ($employeeResult && $deductionResult && $holidayResult && $scheduleResult && $positionResult) {
    // Fetch the result for employees as an associative array
    $employeeRow = $employeeResult->fetch_assoc();
    // Fetch the result for deductions as an associative array
    $deductionRow = $deductionResult->fetch_assoc();

    $holidayRow = $holidayResult->fetch_assoc();
    // Fetch the result for schedules as an associative array
    $scheduleRow = $scheduleResult->fetch_assoc();
    
    $positionRow = $positionResult->fetch_assoc();

    $holidayCount = $holidayRow['holidayCount'];
    $scheduleCount = $scheduleRow['scheduleCount'];


    // Get the count values
    $employeeCount = $employeeRow['employeeCount'];
    $deductionCount = $deductionRow['deductionCount'];

    $positionCount = $positionRow['positionCount'];


    // Close the result sets
    $employeeResult->close();
    $deductionResult->close();
    $holidayResult->close();
    $scheduleResult->close();
    $positionResult->close();
} else {
    echo "Error executing query: " . $conn->error;
}

// Close the database connection
$conn->close();
?>

  <div class="container">
    <div class="row">

        <!-- Employee Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class="card-header"><b>Employee</b></div>
                <div class="card-body">
                    <h5 class="card-title">No. Of Employee</h5>
                    <p class="card-text"><?php echo "Number of Employees: " . $employeeCount; ?></p>
                    <a class="btn btn-primary shadow" href="nav.php?page=employee.php">Click This</a>
                </div>
            </div>
        </div>

        <!-- Deduction Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                <div class="card-header"><b>Deduction</b></div>
                <div class="card-body">
                    <h5 class="card-title">No. Of Deduction</h5>
                    <p class="card-text"><?php echo "Number of Deductions: " . $deductionCount; ?></p>
                    <a class="btn btn-primary shadow" href="nav.php?page=Deduction.php">Click This</a>
                </div>
            </div>
        </div>

        <!-- Holiday Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                <div class="card-header"><b>Holiday</b></div>
                <div class="card-body">
                    <h5 class="card-title">No. Of Holiday</h5>
                    <p class="card-text"><?php echo "Number of Holidays: " . $holidayCount; ?></p>
                    <a class="btn btn-primary shadow" href="nav.php?page=holiday.php">Click This</a>
                </div>
            </div>
        </div>

        <!-- Schedule Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
                <div class="card-header"><b>Schedule</b></div>
                <div class="card-body">
                    <h5 class="card-title">No. Of Schedule</h5>
                    <p class="card-text"><?php echo "Number of Schedules: " . $scheduleCount; ?></p>
                    <a class="btn btn-primary shadow" href="nav.php?page=schedule.php">Click This</a>
                </div>
            </div>
        </div>

        <!-- First Position Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card text-dark bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header"><b>Position</b></div>
                <div class="card-body">
                    <h5 class="card-title">No. Of Positions</h5>
                    <p class="card-text"><?php echo "Number of Positions: " . $positionCount; ?></p>
                    <a class="btn btn-primary shadow" href="nav.php?page=position.php">Click This</a>
                </div>
            </div>
        </div>

        <!-- Second Position Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-header"><b>Position</b></div>
                <div class="card-body">
                    <h5 class="card-title">No. Of Positions</h5>
                    <p class="card-text"><?php echo "Number of Positions: " . $positionCount; ?></p>
                    <a class="btn btn-primary shadow" href="nav.php?page=position.php">Click This</a>
                </div>
            </div>
        </div>

  


        <div style="width: 100%; max-width: 800px; margin: auto;"> <!-- Adjust width as needed -->
        <canvas id="recordCountChart" width="1000" height="400"></canvas> <!-- Adjust width and height as needed -->
    </div>

    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "payroll_system";
    $tables = ["attendance", "employee", "employee_leaves"]; // Add your table names here

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Initialize arrays to hold data for Chart.js
    $labels = [];
    $data = [];
    $colors = ['rgba(245, 40, 145, 0.8)', 'rgba(0, 40, 161, 0.8)', 'rgba(0, 119, 0, 1)']; // Add more colors as needed

    $colorIndex = 0;

    foreach ($tables as $table) {
        // Query to get count of records for each table
        $sql = "SELECT COUNT(*) AS count FROM $table";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $count = $row['count'];

        // Store table name as label
        $labels[] = $table;

        // Store count as data
        $data[] = $count;

        // Assign color to dataset
        $color = $colors[$colorIndex % count($colors)];
        $colorIndex++;

        // Store color for the dataset
        $backgroundColor[] = $color;
    }

    $conn->close();
    ?>

<script>
    // Chart.js code to display count in a graph for each table
    var ctx = document.getElementById('recordCountChart').getContext('2d');
    var recordCountChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Record Count',
                data: <?php echo json_encode($data); ?>,
                backgroundColor: <?php echo json_encode($backgroundColor); ?>,
                borderColor: <?php echo json_encode($backgroundColor); ?>,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Adjust as needed
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>



        </div>

        </div>