<!DOCTYPE html>
<html>
<head>
    <title>Employee Messages</title>
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
                <a class="nav-link" href="#logout" onclick="logout()">Logout</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-5">
    <h2 class="text-center mb-4">Employee Messages</h2>

    <!-- Table to display messages -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Employee Name</th>
                <th>Message Content</th>
                <th>Sent Time</th>
                <th>Action</th>
                <th>Reply</th>
            </tr>
        </thead>
        <tbody>
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

            // Delete message if delete button is clicked
            if (isset($_GET['delete_id'])) {
                $delete_id = $_GET['delete_id'];
                $delete_sql = "DELETE FROM empmessages WHERE id = $delete_id";

                if ($conn->query($delete_sql) === TRUE) {
                    echo '<div class="alert alert-success">Message deleted successfully.</div>';
                } else {
                    echo '<div class="alert alert-danger">Error deleting message: ' . $conn->error . '</div>';
                }
            }

            // Retrieve messages with employee details
            $sql = "SELECT em.id, e.first_name, e.last_name, em.message_con, em.Sent_time 
                    FROM empmessages AS em 
                    JOIN employee AS e ON em.user_id = e.emp_id 
                    ORDER BY em.Sent_time DESC";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>";
                    echo "<td>" . $row["message_con"] . "</td>";
                    echo "<td>" . $row["Sent_time"] . "</td>";
                    echo "<td><a href='employee_messages1.php?delete_id=" . $row["id"] . "' class='btn btn-danger'>Delete</a></td>";
                    echo "<td><a href='message.php?reply_id=" . $row["id"] . "' class='btn btn-primary'>Reply</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No messages yet.</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function logout() {
        window.location.href = 'login.php';
    }
</script>
</body>
</html>