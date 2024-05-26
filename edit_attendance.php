
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
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session to manage notifications
session_start();

// Set the timezone to Asia/Kolkata
date_default_timezone_set('Asia/Kolkata');

// Database connection parameters
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

// Get employee ID from URL
$emp_id = $_GET['emp_id'];

// Fetch employee attendance details
$sql = "SELECT e.emp_id, e.user_id, e.first_name, e.last_name, e.email, e.phone_number, e.address, e.salary, e.jobPosition, a.attendance_date, a.attendance_status 
        FROM employee e 
        LEFT JOIN attendance a ON e.emp_id = a.empid AND a.attendance_date = CURDATE()
        WHERE e.emp_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $emp_id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update attendance status
    $attendance_status = $_POST['attendance_status'];
    $stmt = $conn->prepare("UPDATE attendance SET attendance_status = ? WHERE empid = ? AND attendance_date = CURDATE()");
    $stmt->bind_param("si", $attendance_status, $emp_id);
    $stmt->execute();
    
    // Redirect to the main attendance page with success notification
    $_SESSION['notification'] = "Attendance has been successfully updated.";
    header("Location: mark_attendence.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Attendance</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style> body {
    font-family: Arial, sans-serif;
    background-image: url('img/background/6.jpg'); /* Ensure the correct relative path to your image */
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    margin: 0;
    padding: 0;
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
        <li class="nav-item  ">
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
            <li class="nav-item active dropdown ">
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
<body>
    <div class="container">
        <h2 class="mt-5 mb-3">Edit Attendance for <?php echo $employee['first_name'] . ' ' . $employee['last_name']; ?></h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="attendance_status">Attendance Status</label>
                <select class="form-control" id="attendance_status" name="attendance_status">
                    <option value="Present" <?php echo ($employee['attendance_status'] == 'Present') ? 'selected' : ''; ?>>Present</option>
                    <option value="Absent" <?php echo ($employee['attendance_status'] == 'Absent') ? 'selected' : ''; ?>>Absent</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="mark_attendence.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
