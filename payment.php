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

// Fetch order details for the given order ID
$order_id = $_GET['order_id'] ?? null;
if (!$order_id) {
    header("Location: customer_order.php");
    exit();
}

$sql = "SELECT o.*, u.username FROM orders o JOIN users u ON o.userId = u.id WHERE o.id = $order_id AND o.userId = {$_SESSION['userId']}";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header("Location: customer_order.php");
    exit();
}

$row = $result->fetch_assoc();

// Fetch payment details for the given order ID
$sql_payment = "SELECT * FROM payments WHERE orderId = $order_id";
$result_payment = $conn->query($sql_payment);

if ($result_payment->num_rows > 0) {
    $payment_row = $result_payment->fetch_assoc();
    $paymentStatus = $payment_row['payStatus'];
} else {
    $paymentStatus = 'Not Done';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin-top: 50px;
            margin-left: auto;
            margin-right: auto;
            background-color: #ffffff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #007bff;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            text-align: center;
        }

        label {
            font-weight: bold;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .btn:hover {
            opacity: 0.9;
        }

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="#">Axes Glow</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="my_profile.php">My Profile</a>
            </li>
           
            <li class="nav-item dropdown active">
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
            <li class="nav-item">
                <a class="nav-link" href="customer_delivery.php">Track order</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>
   

    <div class="container">
        <h2>Payment Details</h2>
        <form action="process_payment.php" method="post">
            <div class="form-group">
                <label for="orderId">Order ID</label>
                <input type="text" class="form-control" id="orderId" name="orderId" value="<?php echo $row['id']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $row['phone']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="amount">Amount (Rs)</label>
                <input type="text" class="form-control" id="amount" name="amount" value="<?php echo $row['advancePay']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="paymentStatus">Payment Status</label>
                <input type="text" class="form-control" id="paymentStatus" name="paymentStatus" value="<?php echo $paymentStatus; ?>" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Pay Now</button>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>
