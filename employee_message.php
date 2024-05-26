
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
<!DOCTYPE html>
<html>
<head>
    <title>Message Board</title>
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
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333333;
            text-align: center;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #dddddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            margin-top: 20px;
            margin-left: auto;
            margin-right: auto;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .message-success {
            color: green;
            margin-top: 10px;
            text-align: center;
        }
        .message-error {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
        .btn-view-messages {
            display: block;
            width: 100%;
            padding: 10px 20px;
            background-color: #28a745;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
        }
        .btn-view-messages:hover {
            background-color: #218838;
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
                <li class="nav-item  ">
                    <a class="nav-link" href="employee_home.php">Home</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="candidates1.php">Candidates</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="orders1.php">Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="enquiries1.php">Enquiries</a>
                </li>
                <li class="nav-item active dropdown ">
    <a class="nav-link  dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
    <h2>Send a Message</h2>

    <!-- Displaying Employee Name -->
    <?php
   
    $employeeFirstName = $_SESSION['first_name'] ?? '';
    $employeeLastName = $_SESSION['last_name'] ?? '';
    $employeeId = $_SESSION['emp_id'] ?? '';

    echo "<p>Logged in as: $employeeFirstName $employeeLastName</p>";
    echo "<p>Employee ID: $employeeId</p>";  // Debugging line
    ?>

    <!-- Message Form -->
    <form method="post" action="">
        <label for="new_message">Message:</label>
        <textarea id="new_message" name="new_message" rows="4" cols="50"></textarea>
        <input type="submit" value="Send" class="btn btn-primary">
    </form>

    <!-- View Admin Messages Button -->
    <button class="btn btn-success btn-view-messages" onclick="viewAdminMessages()">View admin Messages</button>

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

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $message_content = $_POST['new_message'];

        // Insert message into empmessages table
        $sql = "INSERT INTO empmessages (user_id, firstname, lastname, message_con) VALUES ('$employeeId', '$employeeFirstName', '$employeeLastName', '$message_content')";

        if ($conn->query($sql) === TRUE) {
            echo '<div class="message-success">Message sent successfully.</div>';
        } else {
            echo '<div class="message-error">Error: ' . $sql . '<br>' . $conn->error . '</div>';
        }
    }

    $conn->close();
    ?>

</div>

<!-- JavaScript for View Admin Messages Button -->
<script>
    function viewAdminMessages() {
        window.location.href = 'admin_messages.php';
    }
</script>

<!-- Bootstrap JS and jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function logout() {
        window.location.href = 'logout1.php';
    }

    // Admin dashboard scripts can be added here

</script>
</body>
</html>