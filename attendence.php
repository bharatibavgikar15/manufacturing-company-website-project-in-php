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
// Initialize notification variable
$notification = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Prepare and bind parameters for the insertion query
    $stmt = $conn->prepare("INSERT INTO attendance (empid, attendance_date, attendance_status) VALUES (?, CURRENT_DATE(), ?)");
    $stmt->bind_param("is", $emp_id, $attendance_status);

    // Iterate through each employee's attendance status
    foreach ($_POST['attendance_status'] as $emp_id => $attendance_status) {
        // Execute the statement
        $stmt->execute();
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Set notification message
    $notification = "Attendance has been successfully marked.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Attendance</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

        /* Custom styles */
        table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }
        th, td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        th {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            font-weight: bold;
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn-mark-attendance {
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
            cursor: pointer;
        }
        .radio-label {
            margin-right: 10px;
        }
    </style>
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
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
        <h2 class="mt-5 mb-3">Employee Attendance</h2>
        <?php if (!empty($notification)) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $notification; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <form action="mark_attendence.php" method="post">
            <input type="hidden" name="attendance_date" value="<?php echo date('Y-m-d'); ?>">

            <table class="table">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>User ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th>Salary</th>
                        <th>Job Position</th>
                        <th>Attendance Date</th>
                        <th>Attendance Status</th>
                        <th>Mark Attendance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Set the timezone
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

                    // Fetch employees and check if attendance is already marked for today
                    $sql = "SELECT e.emp_id, e.user_id, e.first_name, e.last_name, e.email, e.phone_number, e.address, e.salary, e.jobPosition 
                            FROM employee e 
                            WHERE NOT EXISTS (
                                SELECT 1 
                                FROM attendance a 
                                WHERE e.emp_id = a.empid AND a.attendance_date = CURDATE()
                            )";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["emp_id"] . "</td>";
                            echo "<td>" . $row["user_id"] . "</td>";
                            echo "<td>" . $row["first_name"] . "</td>";
                            echo "<td>" . $row["last_name"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["phone_number"] . "</td>";
                            echo "<td>" . $row["address"] . "</td>";
                            echo "<td>" . $row["salary"] . "</td>";
                            echo "<td>" . $row["jobPosition"] . "</td>";
                            echo "<td>" . date('Y-m-d') . "</td>"; // Fetching current date correctly
                            echo "<td>";
                            // Display radio buttons for attendance status
                            echo "<label class='radio-label'><input type='radio' name='attendance_status[" . $row["emp_id"]
                            . "]' value='present'> Present</label>";
                            echo "<label class='radio-label'><input type='radio' name='attendance_status[" . $row["emp_id"] . "]' value='absent' checked> Absent</label>";
                            echo "</td>";
                            echo "<td><button type='submit' class='btn btn-primary btn-mark-attendance'>Mark Attendance</button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='12'>All employees have already marked attendance for today.</td></tr>";
                    }
                    $conn->close();
                    ?>
                    
                </tbody>
            </table>
        </form>
    </div>
</body>
</html>
