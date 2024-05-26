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

// Fetch orders for the logged-in user
$sql = "SELECT o.*, u.username FROM orders o JOIN users u ON o.userId = u.id WHERE o.userId = $userId";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Tracking</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        /* Custom CSS styles */
        body {
    font-family: Arial, sans-serif;
    background-image: url('img/background/9.jpg'); /* Ensure the correct relative path to your image */
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    margin: 0;
    padding: 0;
}
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Axes Glow</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="my_profile.php">My Profile</a>
            </li>
           
            <li class="nav-item dropdown ">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Orders
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="customer_page.php">Add orders</a>
                    <a class="dropdown-item" href="customer_order.php">View orders</a>
                    <div class="dropdown-divider"></div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="inquiries.php">Inquiries</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="customer_delivery.php">Track order</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <h1 class="mt-5">Delivery Tracking</h1>
    
    <!-- Delivery tracking form -->
    <form action="customer_delivery.php" method="get">
        <div class="form-group">
            <label for="orderId">Enter your Order ID:</label>
            <input type="text" class="form-control" id="orderId" name="orderId">
        </div>
        <button type="submit" class="btn btn-primary">Track Order</button>
    </form>

    <!-- Display delivery information -->
    <?php
    // Process form submission
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['orderId'])) {
        // Database credentials
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

        // Sanitize input
        $orderId = mysqli_real_escape_string($conn, $_GET['orderId']);

        // Fetch delivery data from the database
        $sql = "SELECT * FROM delivery WHERE orderId = '$orderId'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
    ?>
            <div class="mt-4">
                <h2>Order Details</h2>
                <p><strong>Order ID:</strong> <?php echo $row['orderId']; ?></p>
                <p><strong>Status:</strong> <?php echo $row['deliveryStatus']; ?></p>
                <p><strong>Date:</strong> <?php echo $row['deliveryDate']; ?></p>
                <p><strong>Time:</strong> <?php echo $row['deliveryTime']; ?></p>
                <p><strong>Address:</strong> <?php echo $row['deliveryAddress']; ?></p>
                <p><strong>Agent:</strong> <?php echo $row['deliveryAgent']; ?></p>
                <p><strong>Notes:</strong> <?php echo $row['deliveryNotes']; ?></p>
            </div>
    <?php
        } else {
            echo "<p>No delivery data found for Order ID: $orderId</p>";
        }

        // Close database connection
        $conn->close();
    }
    ?>
</div>

<!-- Bootstrap JS (Optional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
