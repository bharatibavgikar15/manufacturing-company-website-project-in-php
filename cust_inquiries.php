
<?php
// Start the session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['userId'])) {
    // Redirect to the login page
    header("Location: login.php");
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

// Fetch all inquiries
$sql = "SELECT * FROM inquiries";
$inquiriesResult = $conn->query($sql);

if (!$inquiriesResult) {
    die("Error retrieving inquiries: " . $conn->error);
}

// Initialize variables for form submission
$inquiryId = $replyMessage = "";
$replyMessageErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form fields
    if (empty($_POST["replyMessage"])) {
        $replyMessageErr = "Message is required";
    } else {
        $replyMessage = test_input($_POST["replyMessage"]);
    }

    $inquiryId = test_input($_POST["inquiryId"]);
    $userId = test_input($_POST["userId"]);

    // If all fields are valid, insert reply into database
    if (empty($replyMessageErr)) {
        $sql = "INSERT INTO replies (inquiryId, userId, message) VALUES ('$inquiryId', '$userId', '$replyMessage')";
        if ($conn->query($sql) === TRUE) {
            $successMessage = "Reply submitted successfully!";
            // Clear form fields after submission
            $replyMessage = "";
        } else {
            $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Inquiries</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        /* Custom CSS styles */
        body {
    font-family: Arial, sans-serif;
    background-image: url('img/background/6.jpg'); /* Ensure the correct relative path to your image */
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
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="#">Axes Glow</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
        <li class="nav-item ">
                <a class="nav-link" href="admin_profile.php">Profile</a>
            </li>
        <li class="nav-item ">
                <a class="nav-link" href="admin_page.php">Home</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="candidates.php">Candidates</a>

            </li>
            <li class="nav-item">
                <a class="nav-link" href="orders.php">Orders</a>
            </li>
            <li class="nav-item dropdown ">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Employee
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="employee.php">Add Employee</a>
        <a class="dropdown-item" href="view_employee.php">View Employees</a>
        <a class="dropdown-item" href="attendence.php">Attendence</a>
        <a class="dropdown-item" href="mark_attendence.php">Attendence list</a>
        <div class="dropdown-divider"></div>
        <!-- Removed the Employee Reports option -->
        <!--<a class="dropdown-item" href="#">Employee Reports</a>-->
    </div>
</li>

            <li class="nav-item">
                <a class="nav-link" href="enquiries.php">Enquiries</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="message.php">Message</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="payments.php">Payments</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="cust_inquiries.php">Customer inquiries</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="delivery.php">Deliverey status</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php" onclick="logout()">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<body>
<div class="container">
    <h1 class="mt-5">Customer Inquiries</h1>

    <?php
    if (isset($successMessage)) {
        echo "<div class='alert alert-success' role='alert'>$successMessage</div>";
    }
    if (isset($errorMessage)) {
        echo "<div class='alert alert-danger' role='alert'>$errorMessage</div>";
    }
    ?>

    <!-- Display Existing Inquiries -->
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

            // Reply Form
            echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' class='mt-3'>";
            echo "<div class='form-group'>";
            echo "<label for='replyMessage'>Reply Message:</label>";
            echo "<textarea class='form-control' id='replyMessage' name='replyMessage' rows='4'></textarea>";
            echo "<span class='error'>$replyMessageErr</span>";
            echo "</div>";
            echo "<input type='hidden' name='inquiryId' value='$inquiryId'>";
            echo "<input type='hidden' name='userId' value='" . $inquiry['userId'] . "'>";
            echo "<button type='submit' class='btn btn-primary'>Submit Reply</button>";
            echo "</form>";

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

</body>
</html>
