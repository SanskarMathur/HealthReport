<?php
// By default I am entering my details (for running and debugging the application)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'user-database';

// Establishing Connection with DB
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection Failed : " . $conn->connect_error);
}

// Handle form submission (POST Request to post the file into database)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $weight = $_POST['weight'];
    $email = $_POST['email'];
    $healthReport = $_FILES['healthReport'];

    // Move the uploaded PDF file to the uploads directory
    $uploadDirectory = 'uploads/';
    // Saving the file at the path with the name of the pdf same name as the user
    $uploadedFilePath = $uploadDirectory . basename($healthReport['name']);
    if (move_uploaded_file($healthReport['tmp_name'], $uploadedFilePath)) {
        // SQL QUERY to Insert the user details and file path into the database
        $sql = "INSERT INTO user(name, age, weight, email, health_report_path) 
                VALUES ('$name', '$age', '$weight', '$email', '$uploadedFilePath')";

        // Check if form is submitted successfully
        if ($conn->query($sql) === TRUE) {
            echo "Form submitted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading the file.";
    }
}

// Close the database connection
$conn->close();
?>