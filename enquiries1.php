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

$sql = "SELECT * FROM enquiries";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquiries</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
        

        

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            overflow-y: auto; /* Add scrollbar */
            max-height: 500px; /* Set maximum height */
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
                <li class="nav-item">
                    <a class="nav-link" href="candidates1.php">Candidates</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="orders1.php">Orders</a>
                </li>
                <li class="nav-item active">
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
                <a class="nav-link" href="delivery1.php">Delivery status</a>
            </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout1.php" onclick="logout()">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

<div class="container">
    <h2>Enquiries</h2>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Message</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["phone"] . "</td>";
                    echo "<td>" . $row["message"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No enquiries found</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function logout() {
        window.location.href = 'logout1.php';
    }
</script>
</body>
</html>
