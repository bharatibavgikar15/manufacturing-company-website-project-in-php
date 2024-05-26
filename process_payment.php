<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Check if user is logged in
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "bharati1";
$password = "arti";
$dbname = "axesglow";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userId = $_SESSION['userId'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderId = $_POST['orderId'];
    $paymentMethod = $_POST['paymentMethod'];

    // Update the payment status in the database
    $stmt = $conn->prepare("UPDATE orders SET paymentStatus = 'Paid', paymentMethod = ? WHERE id = ? AND userId = ?");
    
    if (!$stmt) {
        $_SESSION['error'] = "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        header("Location: customer_order.php");
        exit();
    }

    $stmt->bind_param("ssi", $paymentMethod, $orderId, $userId);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Payment successful.";
    } else {
        $_SESSION['error'] = "Error processing payment: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

header("Location: customer_order.php");
exit();
?>
