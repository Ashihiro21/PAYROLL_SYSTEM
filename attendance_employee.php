<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Clock with Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column; /* Added to center align content vertically */
        }

        #clock {
            font-size: 36px;
            text-align: center;
            margin-bottom: 20px; /* Added margin to separate clock from form */
        }
        
        #date {
            font-size: 24px;
            text-align: center;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .success-message,
        .error-message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div id="clock"></div>
    <div id="date"></div>

    <?php
    session_start(); // Resume the session

    if(isset($_SESSION['success_message'])) {
        echo '<div class="success-message">' . $_SESSION['success_message'] . '</div>';
        unset($_SESSION['success_message']); // Remove the success message from session to prevent displaying it again on page refresh
    } elseif(isset($_SESSION['error_message'])) {
        echo '<div class="error-message">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']); // Remove the success message from session to prevent displaying it again on page refresh
    }
    ?>

    <form method="post" action="submit.php">
        <label for="Employee_No">Employee ID:</label>
        <input type="text" id="Employee_No" name="Employee_No" required><br><br>
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required><br><br>
        <label for="log_type">Select Time Type:</label>
        <select id="log_type" name="log_type">
            <option value="time_in">Time In AM</option>
            <option value="time_out">Time Out AM</option>
            <option value="time_in2">Time In PM</option>
            <option value="overtime">Overtime</option>
            <option value="time_out2">Time Out PM</option>
        </select><br><br>
        <input type="hidden" id="time" name="time">
        <input type="submit" value="Submit" onclick="populateHiddenFields()">
    </form>

    <script>
        // Function to update the clock every second
        function updateClock() {
            var now = new Date();
            var hours = now.getHours();
            var minutes = now.getMinutes();
            var seconds = now.getSeconds();
            var day = now.getDate();
            var month = now.getMonth() + 1; // getMonth() returns 0-11 for months, so we add 1
            var year = now.getFullYear();
            var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            var dayOfWeek = days[now.getDay()];

            // Convert hours to AM/PM format
            var ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // Handle midnight (0 hours)

            // Add leading zeros if necessary
            hours = (hours < 10) ? "0" + hours : hours;
            minutes = (minutes < 10) ? "0" + minutes : minutes;
            seconds = (seconds < 10) ? "0" + seconds : seconds;
            day = (day < 10) ? "0" + day : day;
            month = (month < 10) ? "0" + month : month;

            // Update the clock display
            document.getElementById('clock').textContent = hours + ":" + minutes + ":" + seconds + " " + ampm;
            document.getElementById('date').textContent = dayOfWeek + ", " + day + "/" + month + "/" + year;

            // Update the hidden input field with current time
            document.getElementById('time').value = hours + ":" + minutes;
        }

        // Call updateClock function every second
        setInterval(updateClock, 1000);

        // Function to populate hidden input field with current time when form is submitted
        function populateHiddenFields() {
            var selectedTimeType = document.getElementById("log_type").value;
            var now = new Date();
            var hours = now.getHours();
            var minutes = now.getMinutes();

            // Add leading zeros if necessary
            hours = (hours < 10) ? "0" + hours : hours;
            minutes = (minutes < 10) ? "0" + minutes : minutes;

            // Combine hours and minutes into 24-hour format
            var currentTime = hours + ":" + minutes;
            document.getElementById("time").value = currentTime;
        }
    </script>
</body>
</html>
