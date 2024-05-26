
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
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
        v
        <div class="dropdown-divider"></div>
        <!-- Removed the Employee Reports option -->
        <!--<a class="dropdown-item" href="#">Employee Reports</a>-->
    </div>
</li>

            <li class="nav-item">
                <a class="nav-link" href="enquiries.php">Enquiries</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="message.php">Message</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="payments.php">Payments</a>
            </li>
            <li class="nav-item">
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

<div class="container mt-5">
    <h2 class="text-center mb-4">Send a Message</h2>
    
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
        $sender_id = 1; // Assuming admin is always the sender
        $recipient_id = $_POST['employee'];
        $message_content = $_POST['message'];

        $sql = "INSERT INTO messages (sender_id, recipient_id, message_content) VALUES ('$sender_id', '$recipient_id', '$message_content')";

        if ($conn->query($sql) === TRUE) {
            echo '<div class="alert alert-success">Message sent successfully.</div>';
        } else {
            echo '<div class="alert alert-danger">Error: ' . $sql . '<br>' . $conn->error . '</div>';
        }
    }

    $conn->close();
    ?>
    
    <form method="post">
        <div class="form-group">
            <label for="employee">To:</label>
            <select class="form-control" id="employee" name="employee" required>
                <?php
                $conn = new mysqli($servername, $username, $password, $dbname);

                $sql = "SELECT emp_id, first_name, last_name FROM employee";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["emp_id"] . "'>" . $row["first_name"] . " " . $row["last_name"] . "</option>";
                    }
                } else {
                    echo "<option>No employees available</option>";
                }

                $conn->close();
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="message">Message:</label>
            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send</button>
    </form>
</div>

<div class="container mt-3">
    <h2 class="text-center mb-4">Employee Messages</h2>
    
    <button type="button" class="btn btn-info btn-block" onclick="viewAdminMessages()">View employee Messages</button>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function logout() {
        window.location.href = 'logout.php';
    }

    function viewAdminMessages() {
        window.location.href = 'employee_messages1.php';
    }
</script>
</body>

</html>
