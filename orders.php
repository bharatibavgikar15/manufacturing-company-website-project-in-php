
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

// Delete function
if(isset($_GET['delete_id'])) {
    $delete_id = filter_var($_GET['delete_id'], FILTER_SANITIZE_NUMBER_INT);  // Sanitize the input

    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute() === TRUE) {
        header("Location: orders.php");
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
}

if(isset($_POST['accept_id'])) {
    $accept_id = filter_var($_POST['accept_id'], FILTER_SANITIZE_NUMBER_INT);  // Sanitize the input

    $stmt = $conn->prepare("UPDATE orders SET status = 'Accepted' WHERE id = ?");
    $stmt->bind_param("i", $accept_id);

    if ($stmt->execute() === TRUE) {
        $_SESSION['success'] = "Order accepted successfully.";
        header("Location: orders.php");
        exit();
    } else {
        $_SESSION['error'] = "Error accepting order: " . $stmt->error;
    }
}

if(isset($_POST['advancePay'])) {
    foreach($_POST['advancePay'] as $order_id => $advance_pay) {
        $order_id = filter_var($order_id, FILTER_SANITIZE_NUMBER_INT);
        $advance_pay = filter_var($advance_pay, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        $stmt = $conn->prepare("UPDATE orders SET advancePay = ? WHERE id = ?");
        $stmt->bind_param("di", $advance_pay, $order_id);

        if ($stmt->execute() === FALSE) {
            $_SESSION['error'] = "Error updating advance pay for order ID " . $order_id . ": " . $stmt->error;
        } else {
            $_SESSION['success'] = "Advance pay updated successfully.";
        }
    }
}


// Fetch orders
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Orders</title>
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
            max-width: 1200px;
            margin-top: 50px;
            margin-left: auto;
            margin-right: auto;
            overflow-y: auto;
            background-color: #ffffff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            overflow-x: auto;
            background-color: #ffffff;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
            text-transform: uppercase;
            font-weight: bold;
            border-radius: 8px;
        }

        tr:hover {
            background-color: #e6f7ff;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }

        .btn-secondary {
            background-color: #28a745;
            border-color: #28a745;
            color: #fff;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            color: #fff;
        }

        .btn:hover {
            opacity: 0.9;
        }

        h2 {
            color: #007bff;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            text-align: center;
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
            <li class="nav-item">
            <a class="nav-link" href="candidates.php">Candidates</a>

            </li>
            <li class="nav-item active">
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
    <h2>Order Details</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger" role="alert" name="validationError">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success" role="alert" name="validationSuccess">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    <div style="overflow-x:auto;">
        <form method="post" action="orders.php">
            <table class="table table-bordered">
                <thead>
                    <tr class="highlight">
                        <th>ID</th>
                        <th>Organization Name</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Instructions</th>
                        <th>PDF File</th>
                        <th>Additional File</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Advance Pay (Rs)</th>
                        <th>Payment Status</th>
                        <th>Timestamp</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["organizationName"] . "</td>";
                            echo "<td>" . $row["product"] . "</td>";
                            echo "<td>" . $row["quantity"] . "</td>";
                            echo "<td>" . $row["instructions"] . "</td>";
                            echo "<td>";
                            if($row["pdfFile"]) {
                                echo "<a href='download.php?file=" . $row["pdfFile"] . "' class='btn btn-primary'>Download PDF</a>";
                            } else {
                                echo "N/A";
                            }
                            echo "</td>";
                            echo "<td>";
                            if($row["additionalFile"]) {
                                echo "<a href='download.php?file=" . $row["additionalFile"] . "' class='btn btn-secondary'>Download Additional</a>";
                            } else {
                                echo "N/A";
                            }
                            echo "</td>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["phone"] . "</td>";
                            echo "<td>" . $row["address"] . "</td>";
                            echo "<td><input type='text' name='advancePay[" . $row["id"] . "]' value='" . $row["advancePay"] . "'></td>";
                            echo "<td>" . $row["paymentStatus"] . "</td>";
                            echo "<td>" . $row["timestamp"] . "</td>";
                            echo "<td>" . $row["status"] . "</td>";
                            echo "<td>";
                            echo "<a href='orders.php?delete_id=" . $row["id"] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this order?\")'>Delete</a> ";
                            if($row["status"] != 'Accepted') {
                                echo "<button type='submit' name='accept_id' value='" . $row["id"] . "' class='btn btn-success'>Accept</button ";
                                
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='16'>No orders found.</td></tr>";
                    }
                    ?>
                </tbody>
                </table>
            <button type="submit" class="btn btn-primary">Update Advance Pay</button>
            </table>
        </form>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>