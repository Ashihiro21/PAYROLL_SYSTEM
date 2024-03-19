<?php
session_start();
include_once('db_config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['email'])) {
    // Validate and sanitize the input (add more validation as needed)
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $department = filter_input(INPUT_POST, 'department', FILTER_SANITIZE_STRING);
    $position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    // Process and save the uploaded image if it exists
    if(isset($_FILES['images']) && $_FILES['images']['error'] === UPLOAD_ERR_OK) {
        $imagePath = 'img/'; // Specify the folder where you want to save the images
        $imageName = $_FILES['images']['name'];
        $imageTemp = $_FILES['images']['tmp_name'];
        $imageFullPath = $imagePath . $imageName;

        // Move the uploaded image to the specified folder
        move_uploaded_file($imageTemp, $imageFullPath);
    }

    // Update the admin's information in the database
    $updateSql = "UPDATE employee SET first_name = :firstName, last_name = :lastName, department = :department, 
                  position = :position, password = :password, email = :email";
    if(isset($imageFullPath)) {
        // If an image was uploaded, include it in the update query
        $updateSql .= ", images = :images";
    }
    $updateSql .= " WHERE email = :email";
    
    $stmt = $conn->prepare($updateSql);
    $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
    $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
    $stmt->bindParam(':department', $department, PDO::PARAM_STR);
    $stmt->bindParam(':position', $position, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    if(isset($imageFullPath)) {
        // If an image was uploaded, bind its path to the statement
        $stmt->bindParam(':images', $imageFullPath, PDO::PARAM_STR);
    }
    $stmt->bindParam(':email', $_SESSION['email'], PDO::PARAM_STR);


if ($stmt->execute()) {
    echo "Profile updated successfully";
    // JavaScript code for auto-refresh after 2 seconds
} else {
    echo "Failed to update profile";
}
    $stmt->closeCursor();
} else {
    echo "Invalid request";
}
?>
