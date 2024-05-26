<?php
// Database configuration
$servername = "localhost"; // Replace 'localhost' with your MySQL server hostname
$username = "bharati1"; // Replace 'your_username' with your MySQL username
$password = "arti"; // Replace 'your_password' with your MySQL password
$database = "axesglow"; // Replace 'your_database' with your MySQL database name

// Create connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optional: Set charset to UTF-8
mysqli_set_charset($connection, "utf8");
?>
