<?php
// Start the session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['emp_id'])) {
    // Redirect to the login page
    header("Location: employee_login.php");
    exit(); // Ensure that no further code is executed after the redirect
}
?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Database connection
$servername = "localhost";
$username = "bharati1";
$password = "arti";
$dbname = "axesglow";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



// Fetch orders for the logged-in user


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Management</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        /* Custom CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-image: url('img/background/10.jpg'); /* Ensure the correct relative path to your image */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent background for readability */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add shadow for a better look */
            padding: 10px 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .table-responsive {
            margin-top: 20px;
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
<nav class="navbar navbar-expand-lg navbar-light fixed-top ">
        <a class="navbar-brand" href="#">Axes Glow</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item  ">
                    <a class="nav-link" href="employee_home.php">Home</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="candidates1.php">Candidates</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="orders1.php">Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="enquiries1.php">Enquiries</a>
                </li>
                <li class="nav-item  dropdown ">
    <a class="nav-link  dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Message
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="admin_messages.php">View Messages</a>
        <a class="dropdown-item" href="employee_message.php">Send Message</a>
    </div>
</li>
<li class="nav-item">
                <a class="nav-link" href="payments1.php">Payments</a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="delivery1.php">Deliverey status</a>
            </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout1.php" onclick="logout()">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    
    </br>
    </br>
<div class="container">
    <h1 class="mt-2">Delivery Management</h1>
    
    <!-- Add form for inserting new delivery status -->
    <div class="row mt-4">
        <!-- Insert Delivery Status -->
        <div class="col-md-6">
            <h2>Insert Delivery Status</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="orderId">Order ID:</label>
                    <input type="text" class="form-control" id="orderId" name="orderId">
                </div>
                <div class="form-group">
                    <label for="status">New Status:</label>
                    <select class="form-control" id="status" name="status">
                        <option value="Pending">Pending</option>
                        <option value="Started">Started</option>
                        <option value="In Process">In Process</option>
                        <option value="Dispatched">Dispatched</option>
                        <option value="Done">Done</option>
                        <option value="Delivered">Delivered</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="deliveryDate">Delivery Date:</label>
                    <input type="date" class="form-control" id="deliveryDate" name="deliveryDate">
                </div>
                <div class="form-group">
                    <label for="deliveryTime">Delivery Time:</label>
                    <input type="time" class="form-control" id="deliveryTime" name="deliveryTime">
                </div>
                <div class="form-group">
                    <label for="deliveryAddress">Delivery Address:</label>
                    <textarea class="form-control" id="deliveryAddress" name="deliveryAddress" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="deliveryAgent">Delivery Agent:</label>
                    <input type="text" class="form-control" id="deliveryAgent" name="deliveryAgent">
                </div>
                <button type="submit" class="btn btn-primary">Insert Status</button>
            </form>
        </div>
        
        <!-- Add form for updating delivery status -->
        <div class="col-md-6">
            <h2>Update Delivery Status</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="updateOrderId">Order ID:</label>
                    <input type="text" class="form-control" id="updateOrderId" name="updateOrderId">
                </div>
                <div class="form-group">
                    <label for="newStatus">New Status:</label>
                    <select class="form-control" id="newStatus" name="newStatus">
                        <option value="Pending">Pending</option>
                        <option value="Started">Started</option>
                        <option value="In Process">In Process</option>
                        <option value="Dispatched">Dispatched</option>
                        <option value="Done">Done</option>
                        <option value="Delivered">Delivered</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="deliveryDate">Delivery Date:</label>
                    <input type="date" class="form-control" id="deliveryDate" name="deliveryDate">
                </div>
                <div class="form-group">
                    <label for="deliveryTime">Delivery Time:</label>
                    <input type="time" class="form-control" id="deliveryTime" name="deliveryTime">
                </div>
                <div class="form-group">
                    <label for="deliveryAddress">Delivery Address:</label>
                    <textarea class="form-control" id="deliveryAddress" name="deliveryAddress" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="deliveryAgent">Delivery Agent:</label>
                    <input type="text" class="form-control" id="deliveryAgent" name="deliveryAgent">
                </div>
                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS (Optional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function logout() {
        window.location.href = 'logout1.php';
    }

    // Admin dashboard scripts can be added here

</script>

</body>
</html>

<?php
// Process form submission for inserting new delivery status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['orderId']) && isset($_POST['status'])) {
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

    // Validate and sanitize inputs
    $orderId = mysqli_real_escape_string($conn, $_POST['orderId']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $deliveryDate = mysqli_real_escape_string($conn, $_POST['deliveryDate']);
    $deliveryTime = mysqli_real_escape_string($conn, $_POST['deliveryTime']);
    $deliveryAddress = mysqli_real_escape_string($conn, $_POST['deliveryAddress']);
    $deliveryAgent = mysqli_real_escape_string($conn, $_POST['deliveryAgent']);

    // Check if record with the given order ID exists in the orders table
    // Check if record with the given order ID exists in the delivery table
$check_delivery_sql = "SELECT * FROM delivery WHERE orderId = '$orderId'";
$check_delivery_result = $conn->query($check_delivery_sql);

if ($check_delivery_result->num_rows > 0) {
    echo "<script>alert('Delivery record for the provided order ID already exists');</script>";
} else {
    // Insert new delivery record into the database
    $insert_sql = "INSERT INTO delivery (orderId, deliveryStatus, deliveryDate, deliveryTime, deliveryAddress, deliveryAgent) VALUES ('$orderId', '$status', '$deliveryDate', '$deliveryTime', '$deliveryAddress', '$deliveryAgent')";
    if ($conn->query($insert_sql) === TRUE) {
        echo "<script>alert('New delivery record inserted successfully');</script>";
    } else {
        echo "Error inserting delivery record: " . $conn->error;
    }
}


    // Close database connection
    $conn->close();
}

// Process form submission for updating delivery status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateOrderId']) && isset($_POST['newStatus'])) {
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

    // Validate and sanitize inputs
    $updateOrderId = mysqli_real_escape_string($conn, $_POST['updateOrderId']);
    $newStatus = mysqli_real_escape_string($conn, $_POST['newStatus']);
    $deliveryDate = mysqli_real_escape_string($conn, $_POST['deliveryDate']);
    $deliveryTime = mysqli_real_escape_string($conn, $_POST['deliveryTime']);
    $deliveryAddress = mysqli_real_escape_string($conn, $_POST['deliveryAddress']);
    $deliveryAgent = mysqli_real_escape_string($conn, $_POST['deliveryAgent']);

    // Update delivery status in the database
    $update_sql = "UPDATE delivery SET deliveryStatus='$newStatus', deliveryDate='$deliveryDate', deliveryTime='$deliveryTime', deliveryAddress='$deliveryAddress', deliveryAgent='$deliveryAgent' WHERE orderId='$updateOrderId'";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Delivery status updated successfully');</script>";
    } else {
        echo "Error updating delivery status: " . $conn->error;
    }

    // Close database connection
    $conn->close();
}
?>
