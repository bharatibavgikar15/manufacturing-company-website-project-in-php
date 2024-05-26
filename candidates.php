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
// Database connection
$servername = "localhost";
$username = "bharati1";
$password = "arti";
$dbname = "axesglow";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Accept or Reject function
if(isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];

    if($action == 'accept') {
        $sql = "UPDATE candidates SET status = 'accepted' WHERE id = $id";
    } elseif($action == 'reject') {
        $sql = "UPDATE candidates SET status = 'rejected' WHERE id = $id";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: candidates.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Delete function
if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $sql = "DELETE FROM candidates WHERE id = $delete_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: candidates.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// File download function
if(isset($_GET['file'])) {
    $file = $_GET['file'];
    $filepath = 'uploads/' . $file;

    if(file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
        exit;
    } else {
        echo "File not found!";
    }
}

// Fetch candidates
$sql = "SELECT * FROM candidates";
$result = $conn->query($sql);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Candidates</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 50px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            overflow-y: auto;
            max-height: 600px;
        }

        h2 {
            color: #007bff;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .btn:hover {
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }

            .btn {
                padding: 8px 15px;
            }
        }

        /* Menu styles */
        .menu {
            background-color: #333;
            overflow: hidden;
            padding: 10px 0;
        }

        .menu a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            margin: 0 10px;
            text-decoration: none;
        }

        .menu a:hover {
            background-color: #ddd;
            color: black;
        }

        .menu .active {
            background-color: #007bff;
        }

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light ">
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
            <li class="nav-item active">
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
<div class="container">
    <h2>Candidate Details</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Join Immediately</th>
                <th>File Name</th>
                <th>Job Position</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["userId"] . "</td>";
                    echo "<td>" . $row["firstName"] . " " . $row["middleName"] . " " . $row["surname"] . "</td>";
                    echo "<td>" . $row["address"] . "</td>";
                    echo "<td>" . $row["phone"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["joinImmediately"] . "</td>";
                    echo "<td>" . $row["fileName"] . "</td>";
                    echo "<td>" . $row["jobPosition"] . "</td>";
                    echo "<td>";
                    
                    echo "<a href='candidates.php?file=" . $row["fileName"] . "' class='btn btn-info ml-2'>Download</a>";
                    echo "<a href='candidates.php?delete_id=" . $row["id"] . "' class='btn btn-danger ml-2' onclick='return confirm(\"Are you sure you want to delete this candidate?\")'>Delete</a>"; // Added delete button
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No candidates found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    function logout() {
        window.location.href = 'logout.php';
    }
</script>

</body>
</html>

<?php
$conn->close();
?>