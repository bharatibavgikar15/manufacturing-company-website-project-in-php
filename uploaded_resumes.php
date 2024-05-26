<?php
// Start the session
session_start();

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

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user ID from session
$userId = $_SESSION['userId'];

// Query to select resumes uploaded by the user
$sql = "SELECT * FROM candidates WHERE userId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Array to store uploaded resumes
$resumes = [];

if ($result->num_rows > 0) {
    // Fetch resumes and store in array
    while ($row = $result->fetch_assoc()) {
        $resumes[] = $row;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Resumes</title>
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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
        <a class="navbar-brand" href="#">Axes Glow</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="myprofile.php">My Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="candidate_page.php">Careers</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="uploaded_resumes.php">Application status</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Uploaded Resumes</h2>
        <?php if (count($resumes) > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Middle Name</th>
                        <th scope="col">Surname</th>
                        <th scope="col">Address</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Email</th>
                        <th scope="col">Join Immediately</th>
                        <th scope="col">File Name</th>
                        <th scope="col">Job Position</th>
                        <th scope="col">Resume Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resumes as $resume): ?>
                        <tr>
                            <th scope="row"><?php echo $resume['id']; ?></th>
                            <td><?php echo $resume['firstName']; ?></td>
                            <td><?php echo $resume['middleName']; ?></td>
                            <td><?php echo $resume['surname']; ?></td>
                            <td><?php echo $resume['address']; ?></td>
                            <td><?php echo $resume['phone']; ?></td>
                            <td><?php echo $resume['email']; ?></td>
                            <td><?php echo $resume['joinImmediately']; ?></td>
                            <td><?php echo $resume['fileName']; ?></td>
                            <td><?php echo $resume['jobPosition']; ?></td>
                            <td><?php echo isset($resume['resumeStatus']) ? $resume['resumeStatus'] : 'Submitted'; ?></td>
                            <td>
                                <form method="post" action="withdraw_resume.php">
                                    <input type="hidden" name="resumeId" value="<?php echo $resume['id']; ?>">
                                    <button type="submit" class="btn btn-danger">Withdraw</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No resumes uploaded.</p>
        <?php endif; ?>
        <?php
// Check if withdrawal was successful and display notification if necessary
if (isset($_SESSION['withdrawalSuccess'])) {
    if ($_SESSION['withdrawalSuccess']) {
        echo "<div class='alert alert-success' role='alert'>Withdrawal successful!</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error: Withdrawal failed.</div>";
    }
    // Unset the session variable to prevent displaying the notification again on page refresh
    unset($_SESSION['withdrawalSuccess']);
}
?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
