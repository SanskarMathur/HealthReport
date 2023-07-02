<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'user-database';

// Establishing Connection
$conn = new mysqli($host, $username, $password, $database);

// Check if connection was successful
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// GET request to get the file from the Database
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $email = $_GET['email'];

    $sql = "SELECT health_report_path FROM user WHERE email = '$email'";
    $result = $conn->query($sql);

    // Checking if the PDF is available
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $healthReportPath = $row['health_report_path'];

        // Set the appropriate headers for PDF file download
        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename='health_report.pdf'");

        // Output the PDF file
        readfile($healthReportPath);
    } else {
        echo "No health report found for the provided email.";
    }
}

$conn->close();
?>
