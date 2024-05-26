<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit(); // Stop further execution of the script
}

// Establish connection to the database
$servername = "localhost";
$username = "bharati1";
$password = "arti";
$dbname = "axesglow";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user email from session
$userEmail = $_SESSION['username'];

// Retrieve form data
$organizationName = $_POST['organizationName'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

// Prepare SQL statement to update user profile
$sql = "UPDATE orders SET organizationName = ?, name = ?, email = ?, phone = ? WHERE email = ?";
$stmt = $conn->prepare($sql);

// Check if the query preparation was successful
if (!$stmt) {
    die("Error preparing SQL query: " . $conn->error); // Output the error message
}

// Bind parameters to the prepared statement
$stmt->bind_param("sssss", $organizationName, $name, $email, $phone, $userEmail);

// Execute the prepared statement
if ($stmt->execute()) {
    // Redirect to the profile page with success message
    header("Location: my_profile.php?success=profile_updated");
    exit();
} else {
    // Redirect to the profile page with error message
    header("Location: my_profile.php?error=profile_update_failed");
    exit();
}

// Close the prepared statement
$stmt->close();

// Close the database connection
$conn->close();
?>
