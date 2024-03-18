<!DOCTYPE html>
<html>
<head>
    <title>Record Count Graph</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div style="width: 50vw; margin: auto;"> <!-- Adjust width as needed -->
        <canvas id="recordCountChart" width="400" height="200"></canvas> <!-- Adjust width and height as needed -->
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
    $colors = ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)']; // Add more colors as needed

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
</body>
</html>
