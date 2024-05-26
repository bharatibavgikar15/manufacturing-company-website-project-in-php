<?php
// Start the session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['userId'])) {
    // Redirect to the login page
    header("Location: login.php");
    exit(); // Ensure that no further code is executed after the redirect
}

// Include your database connection file here
include "db_connection.php";

// Fetch the user's current profile information from the database
$userId = $_SESSION['userId'];
$sql = "SELECT * FROM users WHERE id = $userId";
$result = mysqli_query($connection, $sql);
if ($result) {
    $userData = mysqli_fetch_assoc($result);
} else {
    echo "Error: " . mysqli_error($connection);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize the form data
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $currentPassword = $_POST['password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate new password and confirm password
    if ($newPassword !== $confirmPassword) {
        $error = "New password and confirm password do not match.";
    } else {
        // Verify the current password
        if (password_verify($currentPassword, $userData['password'])) {
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the user's profile information in the database
            $updateSql = "UPDATE users SET username = '$username', password = '$hashedPassword' WHERE id = $userId";
            $updateResult = mysqli_query($connection, $updateSql);
            if ($updateResult) {
                // Set the success message in the session
                $_SESSION['success_message'] = "Profile updated successfully!";
                // Redirect to the admin profile page after updating
                header("Location: admin_profile.php");
                exit();
            } else {
                echo "Error updating record: " . mysqli_error($connection);
            }
        } else {
            $error = "Current password is incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Admin Profile</title>
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
            <li class="nav-item active">
                <a class="nav-link" href="admin_profile.php">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_page.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="candidates.php">Candidates</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="orders.php">Orders</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Employee
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="employee.php">Add Employee</a>
                    <a class="dropdown-item" href="view_employee.php">View Employees</a>
                    <a class="dropdown-item" href="attendence.php">Attendence</a>
                    <a class="dropdown-item" href="mark_attendence.php">Attendence list</a>
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
                <a class="nav-link" href="delivery.php">Delivery status</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php" onclick="logout()">Logout</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-5">
    <h2>Edit Admin Profile</h2>
    <?php if (isset($error)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success_message'])) : ?>
        <div class="alert alert-success" role="alert">
            <?php 
            echo $_SESSION['success_message']; 
            unset($_SESSION['success_message']); // Clear the success message after displaying it
            ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($userData['username']); ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Current Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="new_password">New Password:</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
