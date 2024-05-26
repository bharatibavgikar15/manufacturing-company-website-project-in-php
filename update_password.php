<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit(); // Stop further execution of the script
}

// Check if the form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate new password and confirm new password
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    if ($newPassword !== $confirmNewPassword) {
        // Passwords do not match, redirect back with error message
        header("Location: myprofile.php?error=password_mismatch");
        exit();
    }

    // Hash the new password before storing it
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

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

    // Retrieve user ID from session
    $userId = $_SESSION['userId'];

    // Update the password in the database
    $sql = "UPDATE users SET password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // Check if the query preparation was successful
    if (!$stmt) {
        die("Error: " . $conn->error); // Output the error message
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("si", $hashedPassword, $userId);
    $stmt->execute();

    // Close the prepared statement
    $stmt->close();

    // Close the database connection
    $conn->close();

    // Redirect to the profile page with success message
    header("Location: myprofile.php?success=password_updated");
    exit();
} else {
    // If the form data was not submitted via POST method, redirect to myprofile.php
    header("Location: myprofile.php");
    exit();
}
?>
