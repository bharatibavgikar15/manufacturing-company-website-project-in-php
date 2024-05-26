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

// Delete function
if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $sql = "DELETE FROM orders WHERE id = $delete_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: orders.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
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
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .btn-secondary {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
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
<nav class="navbar navbar-expand-lg navbar-light ">
        <a class="navbar-brand" href="#">Axes Glow</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item ">
                    <a class="nav-link" href="employee_home.php">Home</a>
                </li>
                <li class="nav-item  ">
                    <a class="nav-link" href="candidates1.php">Candidates</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="orders1.php">Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="enquiries1.php">Enquiries</a>
                </li>
                <li class="nav-item dropdown ">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
            <li class="nav-item">
                <a class="nav-link" href="delivery1.php">Deliverey status</a>
            </li>
             

                <li class="nav-item">
                    <a class="nav-link" href="logout1.php" onclick="logout()">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

<div class="container">
    <h2>Order Details</h2>
    <div style="overflow-x:auto;">
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
                    <th>Terms Accepted</th>
                    <th>Timestamp</th>
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
                            echo "<a href='orders.php?file=" . $row["pdfFile"] . "' class='btn btn-primary'>Download PDF</a>";
                        } else {
                            echo "N/A";
                        }
                        echo "</td>";
                        echo "<td>";
                        if($row["additionalFile"]) {
                            echo "<a href='orders.php?file=" . $row["additionalFile"] . "' class='btn btn-secondary'>Download Additional</a>";
                        } else {
                            echo "N/A";
                        }
                        echo "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["phone"] . "</td>";
                        echo "<td>" . $row["address"] . "</td>";
                        echo "<td>" . ($row["termsAccepted"] ? "Yes" : "No") . "</td>";
                        echo "<td>" . $row["timestamp"] . "</td>";
                        echo "<td>";
                        
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='14'>No orders found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function logout() {
        window.location.href = 'logout1.php';
    }
</script>
</body>
</html>

<?php
$conn->close();
?>
