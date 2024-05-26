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

// Initialize variables for form submission
$orderId = $message = "";
$orderIdErr = $messageErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form fields
    if (empty($_POST["orderId"])) {
        $orderIdErr = "Order ID is required";
    } else {
        $orderId = test_input($_POST["orderId"]);
    }

    if (empty($_POST["message"])) {
        $messageErr = "Message is required";
    } else {
        $message = test_input($_POST["message"]);
    }

    // If all fields are valid, insert inquiry into database
    if (empty($orderIdErr) && empty($messageErr)) {
        $sql = "INSERT INTO inquiries (orderId, userId, message) VALUES ('$orderId', '$userId', '$message')";
        if ($conn->query($sql) === TRUE) {
            $successMessage = "Inquiry submitted successfully!";
            // Clear form fields after submission
            $orderId = $message = "";
        } else {
            $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Function to sanitize input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Fetch inquiries for the logged-in user
$inquiriesSql = "SELECT * FROM inquiries WHERE userId = $userId";
$inquiriesResult = $conn->query($inquiriesSql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiries</title>
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

        .card {
            margin-bottom: 20px;
        }

        .error {
            color: red;
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
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Orders
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="customer_page.php">Add orders</a>
                    <a class="dropdown-item" href="customer_order.php">View orders</a>
                    <div class="dropdown-divider"></div>
                </div>
            </li>
            <li class="nav-item active">
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
    <h1 class="mt-5">Submit Inquiry</h1>

    <?php
    if (isset($successMessage)) {
        echo "<div class='alert alert-success' role='alert'>$successMessage</div>";
    }
    if (isset($errorMessage)) {
        echo "<div class='alert alert-danger' role='alert'>$errorMessage</div>";
    }
    ?>

    <!-- Inquiry Form -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="orderId">Order ID:</label>
            <input type="text" class="form-control" id="orderId" name="orderId" value="<?php echo $orderId; ?>">
            <span class="error"><?php echo $orderIdErr; ?></span>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea class="form-control" id="message" name="message" rows="4"><?php echo $message; ?></textarea>
            <span class="error"><?php echo $messageErr; ?></span>
        </div>
        <button type="submit" class="btn btn-primary">Submit Inquiry</button>
    </form>

    <h2 class="mt-5">Your Inquiries</h2>

    <!-- Display Existing Inquiries and Replies -->
    <?php
    if ($inquiriesResult->num_rows > 0) {
        while ($inquiry = $inquiriesResult->fetch_assoc()) {
            echo "<div class='card'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>Inquiry ID: " . $inquiry['id'] . "</h5>";
            echo "<p class='card-text'><strong>Order ID:</strong> " . $inquiry['orderId'] . "</p>";
            echo "<p class='card-text'><strong>Message:</strong> " . $inquiry['message'] . "</p>";
            echo "<p class='card-text'><strong>Timestamp:</strong> " . $inquiry['timestamp'] . "</p>";

            // Fetch and display replies for each inquiry
            $inquiryId = $inquiry['id'];
            $replySql = "SELECT * FROM replies WHERE inquiryId = $inquiryId";
            $repliesResult = $conn->query($replySql);

            if ($repliesResult->num_rows > 0) {
                while ($reply = $repliesResult->fetch_assoc()) {
                    echo "<div class='card mt-3'>";
                    echo "<div class='card-body'>";
                    echo "<p class='card-text'><strong>Reply:</strong> " . $reply['message'] . "</p>";
                    echo "<p class='card-text'><strong>Timestamp:</strong> " . $reply['timestamp'] . "</p>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No replies found for this inquiry.</p>";
            }

            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>No inquiries found.</p>";
    }
    ?>
</div>

<!-- Bootstrap JS (Optional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function logout() {
        window.location.href = 'login.php';
    }

    // Admin dashboard scripts can be added here

</script>

</body>
</html>
