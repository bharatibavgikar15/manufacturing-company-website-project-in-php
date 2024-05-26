<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit(); // Stop further execution of the script
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $surname = $_POST['surname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

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

    // Prepare SQL statement to update user information
    $sql = "UPDATE candidates SET firstName=?, middleName=?, surname=?, address=?, phone=?, email=? WHERE userId=?";
    $stmt = $conn->prepare($sql);

    // Check if the statement was prepared successfully
    if (!$stmt) {
        die("Error: " . $conn->error);
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("ssssssi", $firstName, $middleName, $surname, $address, $phone, $email, $userId);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        // Redirect back to the profile page with success message
        header("Location: myprofile.php?success=profile_updated");
        exit();
    } else {
        // Redirect back to the profile page with error message
        header("Location: myprofile.php?error=update_failed");
        exit();
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // If the form is not submitted, redirect to the profile page
    header("Location: myprofile.php");
    exit();
}
?>
