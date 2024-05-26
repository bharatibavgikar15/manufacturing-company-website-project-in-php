<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit(); // Stop further execution of the script
}

// Check if the resume ID is set in the POST request
if (!isset($_POST['resumeId'])) {
    // Redirect to the uploaded resumes page if resume ID is not provided
    header("Location: uploaded_resumes.php");
    exit(); // Stop further execution of the script
}

// Establish connection to the database
$servername = "localhost";
$username = "bharati1";
$password = "arti";
$dbname = "axesglow";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve resume ID from POST data
$resumeId = $_POST['resumeId'];

// Prepare SQL statement to delete the resume record
$sql = "DELETE FROM candidates WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $resumeId);

// Execute the statement
if ($stmt->execute()) {
    // Resume successfully withdrawn
    $_SESSION['withdrawalSuccess'] = true;
} else {
    // Error occurred during withdrawal
    $_SESSION['withdrawalSuccess'] = false;
}

$stmt->close();
$conn->close();

// Redirect back to the uploaded resumes page
header("Location: uploaded_resumes.php");
exit();
?>
