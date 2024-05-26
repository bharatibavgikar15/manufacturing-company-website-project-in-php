<?php
// Start the session
session_start();

// Assuming you have verified the username and password and retrieved the userId from the database
$userId = 123; // Replace 123 with the actual userId retrieved from the database

// Set the userId in the session
$_SESSION['userId'] = $userId;

// Redirect to the profile page or any other page
header("Location: my_profile.php");
exit();
?>
