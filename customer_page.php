<?php
// Start the session
session_start();

// Check if userId is set in the session
if (!isset($_SESSION['userId'])) {
    // Redirect the user to the login page or display an error message
    header("Location: login.php");
    exit(); // Stop further execution
}

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

$notification = "";

// Get userId from session
$userId = $_SESSION['userId'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $organizationName = $_POST['organizationName'];
    $product = $_POST['productName'];
    $quantity = $_POST['quantity'];
    $instructions = $_POST['instructions'];
    $pdfFile = $_FILES['pdfFile']['name'];
    $additionalFile = $_FILES['additionalFile']['name'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $terms = isset($_POST['terms']) ? 1 : 0;

    // File upload paths
    $pdfTargetDir = "uploads/";
    $additionalFileTargetDir = "uploads/";

    // Move uploaded files to specified directory
    move_uploaded_file($_FILES['pdfFile']['tmp_name'], $pdfTargetDir . $pdfFile);
    move_uploaded_file($_FILES['additionalFile']['tmp_name'], $additionalFileTargetDir . $additionalFile);

    // SQL query to insert data into 'orders' table
    $sql = "INSERT INTO orders (userId, organizationName, product, quantity, instructions, pdfFile, additionalFile, name, email, phone, address, termsAccepted) 
            VALUES ($userId, '$organizationName', '$product', $quantity, '$instructions', '$pdfFile', '$additionalFile', '$name', '$email', '$phone', '$address', $terms)";

    if ($conn->query($sql) === TRUE) {
        $notification = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Order submitted successfully! Please wait for accepting the order...
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
    } else {
        $notification = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> ' . $conn->error . '
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://js.stripe.com/v3/"></script>  <!-- Stripe JS library -->

    <style>
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
            background-color: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1, h2, h3 {
            color: #007bff;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .file-upload {
            position: relative;
            overflow: hidden;
            margin-top: 20px;
        }

        .file-upload input.file-input {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }

        .sidenav {
            height: 100%;
            width: 250px;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            padding-top: 20px;
        }

        .sidenav a {
            padding: 10px 15px 10px 30px;
            text-decoration: none;
            font-size: 18px;
            color: #818181;
            display: block;
        }

        .sidenav a:hover {
            color: #f1f1f1;
        }

        .main {
            margin-left: 260px; /* Width of the sidebar + 10px margin */
            padding: 0px 10px;
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

<div class="container mt-5">
    <h1 class="text-center">Axes Glow</h1>
    <h2 class="text-center">Place Your Order</h2>
    <?php echo $notification; ?>

    <form action="#" method="post" enctype="multipart/form-data">
        
        <!-- Organization Name -->
        <div class="form-group">
            <label for="orgNameInput">Organization Name:</label>
            <input type="text" class="form-control" id="orgNameInput" name="organizationName">
        </div>
        
        <!-- Order Details -->
        <div class="form-group">
            <label for="productNameInput">Product/Service Name:</label>
            <input type="text" class="form-control" id="productNameInput" name="productName">
        </div>
        
        <div class="form-group">
            <label for="quantityInput">Quantity:</label>
            <input type="number" class="form-control" id="quantityInput" name="quantity">
        </div>
        
        <div class="form-group">
            <label for="instructionsTextarea">Additional Instructions:</label>
            <textarea class="form-control" id="instructionsTextarea" rows="3" name="instructions"></textarea>
        </div>
        
        <!-- File Upload Section -->
        <div class="form-group">
            <label for="pdfUpload">Upload PDF:</label>
            <input type="file" class="form-control-file" id="pdfUpload" name="pdfFile" accept=".pdf">
        </div>
        
        <div class="form-group">
            <label for="additionalFileUpload">Upload Additional File:</label>
            <input type="file" class="form-control-file" id="additionalFileUpload" name="additionalFile">
        </div>
        
        <!-- Contact Information -->
        <h3>Contact Information</h3>
        
        <div class="form-group">
            <label for="nameInput">Name:</label>
            <input type="text" class="form-control" id="nameInput" name="name">
        </div>
        
        <div class="form-group">
            <label for="emailInput">Email:</label>
            <input type="email" class="form-control" id="emailInput" name="email">
        </div>
        
        <div class="form-group">
            <label for="phoneInput">Phone Number:</label>
            <input type="tel" class="form-control" id="phoneInput" name="phone">
        </div>
        
        <div class="form-group">
            <label for="addressTextarea">Shipping Address:</label>
            <textarea class="form-control" id="addressTextarea" rows="3" name="address"></textarea>
        </div>
        
        <!-- Terms and Conditions -->
        <h3>Terms and Conditions</h3>
        
        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="termsCheck" name="terms" required>
                <label class="form-check-label" for="termsCheck">I accept the following Terms and Conditions:</label>
            </div>
            <ul>
                <li>All orders are subject to availability and confirmation by our team.</li>
                <li>Prices are subject to change without prior notice.</li>
                <li>Payments must be made in full before order processing.</li>
                <li>Orders once placed cannot be canceled or modified.</li>
                <li>We are not responsible for any loss or damage to uploaded files.</li>
                <li>By submitting this order, you agree to provide accurate and complete information.</li>
            </ul>
        </div>
        
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary btn-block">Submit Order</button>
        
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
