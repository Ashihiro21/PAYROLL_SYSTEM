<?php

session_start();
// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

?>


<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "payroll_system";


    // Create a PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the SQL query
    $stmt = $conn->prepare("SELECT COUNT(*) AS row_count FROM attendance WHERE overtime AND num_hr >= 9 AND date = CURDATE() AND admin_approve = 'Pending' ");
    
    // Execute the query
    $stmt->execute();
    
    // Fetch the row count
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $rowCount = $row['row_count'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAYROLL SYSTEM</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">                                                                         
    <script src="https://kit.fontawesome.com/yourkit.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="styles.css">

        <style>
body{
    padding:0px; 
    margin: 0px;
}

.circle-button img {
    width: 50px;   
    height: 50px;  
    border-radius: 50%;
    object-fit: cover;
}

.circle-button{
    background-color: #0e2238;
    border: none;
}

.dropdown-toggle::after{
    color: #0e2238;
}

.tittle {
    margin-left: 1rem;
}

.responsive-image {
    max-width: 100%;
    height: auto;
    padding: 20px;
}

.update_profile_btn{
    border: transparent;
}

.custom-dropdown .dropdown-toggle::after {
    display: none !important;
    background-color: #0e2238;
    border: solid transparent; 
}

.accordion-menu .treeview-menu {
    list-style-type: none;
    background: #0a1828;
    padding-top: 10px;
    padding-bottom: 10px;
    max-height: 80px;
    overflow: hidden;
    transition: max-height 0.5s ease-out;
    
}
.accordion-menu .treeview-menu.open {
    max-height: 200px;
}

.accordion .accordion-button {
    background-color: #0e2238;
    border: none;
}

.accordion .accordion-button:after{
    background-color: green;
}

.accordion-menu .treeview-menu li {
    margin-left: 0;

}

.accordion .accordion-button:hover {
    background-color: rgba(255, 255, 255, -255);
    border-left: 3px solid #3b7ddd;
}

.accordion-button::after {
    display: none !important;
    background-color: #0e2238;
    border: #0e2238; 
    

}





.sidebar-item.accordion-item {
    /* border: none !important; */
    border: none;
    background-color: rgba(255, 255, 255, .075);
    color: #ffffff;
    color:white
}

.accordion-item:focus,
.accordion-item a {
    color: #ffffff !important; 
}

.accordion-item a {
    background: transparent;
    border: none; 
}

.accordion-item a:hover{
    text-decoration: none;

}

a.sidebar-link:hover {
       background-color: rgba(255, 255, 255, -255);
        border-left: 3px solid #3b7ddd;
}
.lni lni-users{
    margin-right:200px
}

.nav-link {
    text-decoration: none;
    color: inherit;
    display: block; /* Change display property to block */
    padding: 10px 15px; /* Add padding for better touch interaction */
}

/* Media query for responsiveness */
@media (max-width: 768px) {
    .nav-link {
        margin-right: 2rem; /* Reduce font size for smaller screens */
    }


}


</style>
</head>

<body>
    <div class="header" style="padding:1rem">
    
        <h1 class='tittle'>Payroll Management System
        
        
        <?php
                    include_once('db_config.php');

                    // Initialize or define the $page variable

                    // Use a parameterized query to prevent SQL injection
                    $sql = "SELECT * FROM admin WHERE username = :username";
                    $stmt = $conn->prepare($sql);

                    // Bind the parameter
                    $stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);

                    // Execute the query
                    $stmt->execute();

                    // Get the result
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
              
                    // Your existing code...
                    if ($result) {
                        echo "
                            <span class='users'>
                                <a class='nav-link' href='nav.php?page=employee_overtime.php'>
                                <i class='lni lni-popup notif'></i>";
                                        echo '<span class="count badge badge-danger" style="font-size: 15px;">' . $rowCount . '</span>';
                        echo "
                                </a>
                                <button class='circle-button dropdown-toggle' 
                                        data-bs-toggle='dropdown' 
                                        aria-expanded='false' 
                                        aria-haspopup='true'
                                        aria-controls='dropdown-menu' 
                                        aria-label='Open user options'>
                                    <img class='User_Image1'  src='{$result['images']}' alt='Profile picture of {$result['first_name']}  {$result['last_name']}'>
                                </button>
                                <div class='text-logo' role='contentinfo' aria-label='User Information'> 
                                    {$result['first_name']}  {$result['last_name']} 
                                </div>
                                <div aria-live='polite' aria-atomic='true' class='dropdown-menu mt-3 id='dropdown-menu' style='width: 300px;'> <!-- Adjust the width as needed -->
                                    <img src='" . $result['images'] . "' alt='Picture of {$result['first_name']} {$result['last_name']}' class='responsive-image'>
                                    <div class='text-logo1' role='contentinfo' aria-label='User Information'>
                                        {$result['first_name']} {$result['last_name']}
                                    </div>
                                    <div class='footer mt-5'>
                                        <button class='btn btn1 ms-2 text-white' style='border: none;' data-bs-toggle='modal' data-bs-target='#updateProfileModal'>
                                            <i class='lni lni-pencil me-4'></i> Update Profile
                                        </button>
                                        <div class='sidebar-footer'>
                                            <a href='logout.php' class='sidebar-link'>
                                                <i class='lni lni-exit'></i><span>Logout</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </span>
                        </a>";
                    } else {
                        echo "0 results";
                    }
                    $stmt->closeCursor();
                    
                   ?>

        </h1>
    
        
    </div>
    <div class="wrapper">

        <aside id="sidebar">
            <div class="d-flex">
                <div class="sidebar-logo">
                <button class="toggle-btn ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar">
                <i class="lni lni-grid-alt"></i>
            </button>
                    <?php
                    include_once('db_config.php');

                    

                    // Initialize or define the $page variable
                    $page = isset($_GET['page']) ? $_GET['page'] : 'admin_dashboard.php';

                    // Use a parameterized query to prevent SQL injection
                    $sql = "SELECT * FROM admin WHERE username = :username";
                    $stmt = $conn->prepare($sql);

                    // Bind the parameter
                    $stmt->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);

                    // Execute the query
                    $stmt->execute();

                    // Get the result
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
              
                    // Your existing code...
                    
                    if ($result) {
                        // Output data
                        echo "<div class='user-info ms-2'>";
                        
                        echo "<img src='" . $result['images'] . "' alt='User Image' class='user-image'>";
                        echo "<a class='text-center m-1' href='#'>";
                        echo $result['first_name'] . " " . $result['last_name'];
                        echo "</a>";
                        echo "</div>";
                    } else {
                        echo "0 results";
                    }
                    
                    // Continue with any remaining code...
                   
                    

                    // Close the statement and connection
                    $stmt->closeCursor(); // optional
                    $conn = null;
                    ?>
                </div>
            </div>
            <ul class="sidebar-nav tree" data-widget="tree">
                
                        <li class="sidebar-item">
                <a href="?page=attendance.php" class="sidebar-link"<?php if ($page === 'attendance.php') echo ' class="active"'; ?>>
                    <i class="lni lni-checkmark-circle"></i> <!-- Replace "lni-checkmark-circle" with the desired LineIcons class -->
                    <span>Attendance</span>
                </a>
            </li>
                
                <li class="sidebar-item">
                    <a href="?page=admin_dashboard.php" class="sidebar-link"<?php if ($page === 'admin_dashboard.php') echo ' class="active"'; ?>>
                    <i class="lni lni-dashboard"></i> <!-- Change this line to set a different icon -->
                    <span>Admin Dashboard</span>
                </a>
            </li>
                    <div class="accordion accordion-menu" id="employeeAccordion">
            <li class="sidebar-item accordion-item">
                <a href="#" class="sidebar-link accordion-button collapsed" id="employeeAccordionHeading" role="button" data-bs-toggle="collapse" data-bs-target="#employeeCollapse" aria-expanded="false" aria-controls="employeeCollapse" style="background-image: none !important;">
                    <i class="lni lni-users"></i><span>Employee Section</span>
                </a>
                <div id="employeeCollapse" class="treeview accordion-collapse collapse" aria-labelledby="employeeAccordionHeading" data-bs-parent="#employeeAccordion">
                    <ul class="treeview-menu">
                    <li>
            <a href="?page=employee.php"<?php if ($page === 'employee.php') echo ' class="active"'; ?> class="accordion-item">
                <i class="lni lni-users"></i> <span>Employees</span>
            </a>
        </li>
        <li>
    <a href="?page=employee_leaves_display.php"<?php if ($page === 'employee_leaves_display.php') echo ' class="active"'; ?> class="accordion-item">
        <i class="lni lni-briefcase"></i> <span>Work Leaves</span>
    </a>
</li>
<li>
    <a href="?page=employee_overtime.php"<?php if ($page === 'employee_overtime.php') echo ' class="active"'; ?> class="accordion-item">
        <i class="fas fa-clock"></i> <span>Overtime</span>
    </a>
</li>

            </ul>
        </div>
    </li>
</div>


<script>
$(document).ready(function () {
    $('.accordion-button').click(function () {
        $(this).toggleClass('collapsed');
        $(this).attr('aria-expanded', $(this).attr('aria-expanded') === 'false' ? 'true' : 'false');

        // Toggle the max-height of the treeview-menu
        var target = $(this).attr('data-bs-target');
        var treeview = $(target);
        if (treeview.css('maxHeight') !== '0px') {
            treeview.css('maxHeight', '0px');
            // Hide the dropdown when the collapse is shown
            $(this).parent().find('.dropdown-menu').hide();
        } else {
            treeview.css('maxHeight', treeview.prop('scrollHeight') + "px");
        }
    });

    // Prevent the dropdown from toggling when the collapse is shown
    $('.treeview-menu').on('shown.bs.collapse', function () {
        $(this).closest('.accordion-button').attr('data-bs-toggle', '');
    });

    // Re-enable dropdown toggling when the collapse is hidden
    $('.treeview-menu').on('hidden.bs.collapse', function () {
        $(this).closest('.accordion-button').attr('data-bs-toggle', 'collapse');
    });
});


</script>




            
            <!-- <li class="sidebar-item">
                <a href="?page=deduction.php" class="sidebar-link"<?php if ($page === 'deduction.php') echo ' class="active"'; ?>>
                    <i class="lni lni-bar-chart"></i>
                    <span>Deduction</span>
                </a>
            </li> -->
            <li class="sidebar-item">
            <a href="?page=holiday.php" class="sidebar-link"<?php if ($page === 'holiday.php') echo ' class="active"'; ?>>
                <i class="lni lni-calendar"></i> <!-- Replace with the new Font Awesome icon class -->
                <span>Holidays</span>
            </a>
        </li>
            <li class="sidebar-item">
            <a href="?page=payslip_payroll.php" class="sidebar-link"<?php if ($page === 'payslip_payroll.php') echo ' class="active"'; ?>>
                <i class="lni lni-files"></i> <!-- Replace with the new Font Awesome icon class -->
                <span>Summary Report</span>
            </a>
        </li>
        </li>
           
        
        <!-- </li>
            <li class="sidebar-item">
            <a href="?page=position.php" class="sidebar-link"<?php if ($page === 'position.php') echo ' class="active"'; ?>>
                <i class="lni lni-briefcase"></i>
                <span>Position</span>
            </a>
        </li> -->
            <li class="sidebar-item">
            <a href="?page=leave.php" class="sidebar-link"<?php if ($page === 'leave.php') echo ' class="active"'; ?>>
                <i class="lni lni-hourglass"></i>
                <span>Leaves</span>
            </a>
        </li>

            
          
        </ul>
        
    </aside>
    <div class="main p-3">
        <div class="text-center">
            <?php
        include($page);
        ?>
            </div>
        </div>
    </div>
</body>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>

$(document).ready(function () {
    // Fetch user data using AJAX
    $.ajax({
        url: "fetch_user_data.php",
        type: "GET",
        success: function (userData) {
            // Populate input fields with user data
            $("#firstName").val(userData.first_name);
            $("#lastName").val(userData.last_name);
            $("#department").val(userData.department);
            $("#position").val(userData.position);
            // Display images if available
            $("#images").val(userData.images);
          
        },
        error: function (error) {
            console.error(error);
        }
    });

    // Handle profile update form submission
    $("#updateProfileForm").submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this); // Gather form data

        // Send AJAX request to update profile
        $.ajax({
            url: "update_profile.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // Handle the response from the server
                console.log(response);
                // Show alert
                alert(response);
                // Refresh the page
                window.location.reload();
            },
            error: function (error) {
                console.error(error);
                // Show error alert
                alert("Error updating profile. Please try again.");
            }
        });
    });
});


        $(document).ready(function () {
            const hamBurger = document.querySelector(".toggle-btn");
            const sidebar = document.querySelector("#sidebar");

            // Initially hide text
            const sidebarTexts = document.querySelectorAll(".sidebar-link span");
            sidebarTexts.forEach(text => {
                text.style.display = "none";
            });

            // Check if the sidebar is initially expanded or stored in localStorage
            const isSidebarExpanded = localStorage.getItem("sidebarExpanded") === "true";

            // Toggle visibility of sidebar text based on the initial state
            sidebarTexts.forEach(text => {
                if (isSidebarExpanded) {
                    text.style.display = "inline";
                } else {
                    text.style.display = "none";
                }
            });

            // Set the initial state or retrieve from localStorage
            sidebar.classList.toggle("expand", isSidebarExpanded);

            hamBurger.addEventListener("click", function () {
                sidebar.classList.toggle("expand");

                // Toggle visibility of sidebar text after the toggle button is clicked
                sidebarTexts.forEach(text => {
                    if (sidebar.classList.contains("expand")) {
                        text.style.display = "inline";
                    } else {
                        text.style.display = "none";
                    }
                });

                // Store the state in localStorage
                localStorage.setItem("sidebarExpanded", sidebar.classList.contains("expand"));
            });
        });




    
</script>

<!-- Update Profile Modal -->
<div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProfileModalLabel">Update Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- Profile Update Form -->
                <form id="updateProfileForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" required>
                    </div>
                    <div class="mb-3">
                        <label for="department" class="form-label">Department</label>
                        <input type="text" class="form-control" id="department" name="department" required>
                    </div>
                    <div class="mb-3">
                        <label for="position" class="form-label">Position</label>
                        <input type="text" class="form-control" id="position" name="position" required>
                    </div>
    
                <!-- New Profile Image Input -->
                <div class="mb-3">
                     <input type="hidden" id="images" name="images">
                    <input type="file" class="form-control" id="images" name="images">
                </div>

                    <!-- Add more form fields as needed -->
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>



</body>

</html>