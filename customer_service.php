<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit(); // Stop further execution of the script
}

// Proceed with database connection and form processing
$successMessage = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if (!isset($_POST['firstName'], $_POST['middleName'], $_POST['surname'], $_POST['address'], $_POST['phone'], $_POST['email'], $_POST['joinImmediately'], $_POST['jobPosition'])) {
        echo "<div class='alert alert-danger mt-3' role='alert'>Please fill out all required fields.</div>";
    } else {
        
    // Establish connection to the database
        $userId = $_SESSION['userId'];
         $servername = "localhost";
        $username = "bharati1";
        $password = "arti";
        $dbname = "axesglow";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Process form data
        $firstName = $_POST['firstName'];
        $middleName = $_POST['middleName'];
        $surname = $_POST['surname'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $joinImmediately = $_POST['joinImmediately'];
        $jobPosition = $_POST['jobPosition'];

        // Check if the email already exists in the candidates table
        $sqlCheckEmail = "SELECT * FROM candidates WHERE email = ?";
        $stmtCheckEmail = $conn->prepare($sqlCheckEmail);
        $stmtCheckEmail->bind_param("s", $email);
        $stmtCheckEmail->execute();
        $resultCheckEmail = $stmtCheckEmail->get_result();

        if ($resultCheckEmail->num_rows > 0) {
            // If the email exists, show a message and provide an option to withdraw the previous resume
            $withdrawalMessage = "<div class='alert alert-warning mt-3' role='alert'>if you want to apply here, please withdraw your previous application.</div>";
            $withdrawalButton = "<form method='post' action='withdraw_resume.php'><input type='hidden' name='email' value='$email'><button type='submit' class='btn btn-danger mt-3'>Withdraw Previous Application</button></form>";
        } else {
            // If the email does not exist, proceed with inserting the new resume
            // File upload code goes here
            if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
                echo "<div class='alert alert-danger mt-3' role='alert'>Error uploading file.</div>";
            } else {
                $file = $_FILES['file'];
                $fileName = $file['name'];
                $fileTmpName = $file['tmp_name'];
                $fileDestination = 'uploads/' . $fileName;

                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    // Retrieve userId from session
                    $userId = $_SESSION['userId'];

                    // Insert data into candidates table
                    $sql = "INSERT INTO candidates (userId, firstName, middleName, surname, address, phone, email, joinImmediately, fileName, jobPosition) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("isssssssss", $userId, $firstName, $middleName, $surname, $address, $phone, $email, $joinImmediately, $fileName, $jobPosition);

                    if ($stmt->execute()) {
                        $successMessage = "<div class='alert alert-success mt-3' role='alert'>Resume inserted successfully.</div>";
                    } else {
                        echo "<div class='alert alert-danger mt-3' role='alert'>Error: " . $sql . "<br>" . $conn->error . "</div>";
                    }

                    $stmt->close();
                } else {
                    echo "<div class='alert alert-danger mt-3' role='alert'>Error moving uploaded file.</div>";
                }
            }
        }
       
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Candidate Form</title>
  
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
            <li class="nav-item active">
                <a class="nav-link" href="candidate_page.php">Careers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="uploaded_resumes.php">Application status</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <h2>Upload resume</h2>
    <?php 
    if(isset($withdrawalMessage)){
        echo $withdrawalMessage;
    }
    ?>
    <form id="candidateForm" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="form-group">
            <label for="firstName">First Name:</label>
            <input type="text" class="form-control" id="firstName" name="firstName" required>
        </div>
        <div class="form-group">
            <label for="middleName">Middle Name:</label>
            <input type="text" class="form-control" id="middleName" name="middleName" required>
        </div>
        <div class="form-group">
            <label for="surname">Surname:</label>
            <input type="text" class="form-control" id="surname" name="surname" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="tel" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="joinImmediately">Join Immediately:</label>
            <select class="form-control" id="joinImmediately" name="joinImmediately" required>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </div>
        <div class="form-group">
            <label for="file">Resume (PDF only):</label>
            <input type="file" class="form-control-file" id="file" name="file" accept=".pdf" required>
        </div>
        <div class="form-group">
            <label for="jobPosition">Job Position:</label>
            <select class="form-control" id="jobPosition" name="jobPosition" required>
                <option value="vmc operator">Customer service and support</option>
                <!-- Add more options as needed -->
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button></br>
        
    </form>
    <?php echo $successMessage; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
