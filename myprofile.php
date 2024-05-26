<?php
// Start the session
session_start();

// Check if there is a success message in the URL
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

// Retrieve user ID from session
$userId = $_SESSION['userId'];

// Query to select user information
$sql = "SELECT firstName, middleName, surname, address, phone, email FROM candidates WHERE userId = ?";
$stmt = $conn->prepare($sql);

// Check if the query preparation was successful
if (!$stmt) {
    die("Error: " . $conn->error); // Output the error message
}

// Bind the user ID parameter
$stmt->bind_param("i", $userId);

// Execute the prepared statement
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

// Fetch user information
if ($result->num_rows > 0) {
    $userInfo = $result->fetch_assoc();
} else {
    // Handle the case where user information is not found
    die("User information not found.");
}

// Close the prepared statement
$stmt->close();

// Query to select password from users table
$sqlPassword = "SELECT password FROM users WHERE id = ?";
$stmtPassword = $conn->prepare($sqlPassword);

// Check if the query preparation was successful
if (!$stmtPassword) {
    die("Error: " . $conn->error); // Output the error message
}

// Bind the user ID parameter
$stmtPassword->bind_param("i", $userId);

// Execute the prepared statement
$stmtPassword->execute();

// Get the result set
$resultPassword = $stmtPassword->get_result();

// Fetch password
if ($resultPassword->num_rows > 0) {
    $passwordRow = $resultPassword->fetch_assoc();
    $currentPassword = $passwordRow['password']; // Fetch the password from the database
} else {
    // Handle the case where password information is not found
    die("Password information not found.");
}

// Close the prepared statement
$stmtPassword->close();

// Handle password change request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = $_POST["currentPassword"];
    $newPassword = $_POST["newPassword"];
    $confirmPassword = $_POST["confirmPassword"];

    if ($newPassword != $confirmPassword) {
        $password_message = "New password and confirm password do not match.";
    } else {
        // Check if the current password matches
        if ($currentPassword != $password) {
            $password_message = "Current password is incorrect.";
        } else {
            // Update the password in the database
            $updatePasswordSql = "UPDATE users SET password = ? WHERE id = ?";
            $stmtUpdatePassword = $conn->prepare($updatePasswordSql);
            $stmtUpdatePassword->bind_param("si", $newPassword, $userId);
            if ($stmtUpdatePassword->execute()) {
                $password_message = "Password updated successfully!";
            } else {
                $password_message = "Error updating password: " . $conn->error;
            }
            $stmtUpdatePassword->close();
        }
    }
}

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
    background-image: url('img/background/login_image.jpg'); /* Ensure the correct relative path to your image */
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">Axes Glow</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="myprofile.php">My Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="candidate_page.php">Careers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="uploaded_resumes.php">Uploaded Resumes</a>
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
        <?php if (isset($successMessage)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-6">
                <form method="post" action="update_profile.php">
                    <div class="form-group">
                        <label for="firstName">First Name:</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $userInfo['firstName']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="middleName">Middle Name:</label>
                        <input type="text" class="form-control" id="middleName" name="middleName" value="<?php echo $userInfo['middleName']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="surname">Surname:</label>
                        <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $userInfo['surname']; ?>" required>
                    </div>
                    <div class="form-group">
                    <textarea class="form-control" id="address" name="address" required><?php echo htmlspecialchars($userInfo['address']); ?></textarea>

                    </div>
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $userInfo['phone']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $userInfo['email']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
            <div class="col-md-6 password-section">
                <h3>Password Settings</h3>
                <?php if (!empty($password_message)) : ?>
                    <div class="alert alert-<?php echo (strpos($password_message, 'successfully') !== false) ? 'success' : 'danger'; ?>">
                        <?php echo $password_message; ?>
                    </div>
                <?php endif; ?>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="currentPassword">Current Password:</label>
                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" value="<?php echo $currentPassword; ?>" required>

                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password:</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm New Password:</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
