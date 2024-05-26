<?php
// Start the session
session_start();

// Check if there is a success message in the URL
$successMessage = '';
if (isset($_GET['success']) && $_GET['success'] === "password_updated") {
    $successMessage = "Password updated successfully!";
}
if (isset($_GET['success']) && $_GET['success'] === "profile_updated") {
    $successMessage = "Profile updated successfully!";
}

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit(); // Stop further execution of the script
}

// Establish connection to the database
$servername = "localhost";
$username = "bharati1";
$password = "arti";
$dbname = "axesglow";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user email from session
$userEmail = $_SESSION['username'];

// Query to select user information
$sql = "SELECT organizationName, name, email, phone FROM orders WHERE email = ?";
$stmt = $conn->prepare($sql);


// Check if the query preparation was successful
if (!$stmt) {
    die("Error preparing SQL query: " . $conn->error); // Output the error message
}

// Bind the email parameter
$stmt->bind_param("s", $userEmail);

// Execute the prepared statement
if (!$stmt->execute()) {
    die("Error executing SQL query: " . $stmt->error);
}

// Get the result set
$result = $stmt->get_result();

// Fetch user information
$userInfo = $result->fetch_assoc();

// Close the prepared statement
$stmt->close();

// Query to select user password
$sqlPassword = "SELECT password FROM users WHERE username = ?";
$stmtPassword = $conn->prepare($sqlPassword);

// Check if the query preparation was successful
if (!$stmtPassword) {
    die("Error preparing SQL query: " . $conn->error); // Output the error message
}

// Bind the email parameter
$stmtPassword->bind_param("s", $userEmail);

// Execute the prepared statement
if (!$stmtPassword->execute()) {
    die("Error executing SQL query: " . $stmtPassword->error);
}

// Get the result set
$resultPassword = $stmtPassword->get_result();

// Fetch user password
$userPassword = $resultPassword->fetch_assoc()['password'];

// Close the prepared statement
$stmtPassword->close();


// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-image: url('img/background/9.jpg'); /* Ensure the correct relative path to your image */
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    margin: 0;
    padding: 0;
}
        .password-section {
            background-color: #e9ecef;
            padding: 20px;
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
            <li class="nav-item active">
                <a class="nav-link" href="my_profile.php">My Profile</a>
            </li>
           
            <li class="nav-item dropdown ">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Orders
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="customer_page.php">Add orders</a>
                    <a class="dropdown-item" href="customer_order.php">View orders</a>
                    <div class="dropdown-divider"></div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="inquiries.php">Inquiries</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="customer_delivery.php">Track order</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>

    <div class="container mt-5">
        <h2>My Profile</h2>
        <!-- Display success message if set -->
        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-6">
                <form method="post" action="updated_customer_profile.php">
                    <div class="form-group">
                        <label for="organizationName">Organization Name:</label>
                        <input type="text" class="form-control" id="organizationName" name="organizationName" value="<?php echo !empty($userInfo['organizationName']) ? $userInfo['organizationName'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo !empty($userInfo['name']) ? $userInfo['name'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo !empty($userInfo['email']) ? $userInfo['email'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo !empty($userInfo['phone']) ? $userInfo['phone'] : ''; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
            <div class="col-md-6 password-section">
                <h3>Password Settings</h3>
                <form method="post" action="customer_updated_password.php">
                <div class="form-group">
    <label for="currentPassword">Current Password:</label>
    <input type="password" class="form-control" id="currentPassword" name="currentPassword" value="<?php echo !empty($userPassword) ? $userPassword : ''; ?>" required>
</div>

                    <div class="form-group">
                        <label for="newPassword">New Password:</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmNewPassword">Confirm New Password:</label>
                        <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
