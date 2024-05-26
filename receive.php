<?php
$servername = "localhost";
$username = "bharati1";
$password = "arti";
$dbname = "axesglow";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO messages (message_content) VALUES (?)");
    $stmt->bind_param("s", $message);

    if ($stmt->execute() === TRUE) {
        echo "Message sent successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
