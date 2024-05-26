<?php
// Database connection
$host = 'localhost';
$dbname = 'axesglow';
$username = 'bharati1';
$password = 'arti';

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && !empty($_GET['id'])) {
        // Fetch the employee by ID
        $stmt = $pdo->prepare("SELECT * FROM employee WHERE emp_id = :emp_id");
        $stmt->bindParam(':emp_id', $_GET['id']);
        $stmt->execute();
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);

    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
        // Update the employee details
        if (isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone_number'], $_POST['address'], $_POST['salary'], $_POST['jobPosition'], $_POST['emp_id'])) {
            
            $stmt = $pdo->prepare("UPDATE employee SET 
                                    first_name = :first_name,
                                    last_name = :last_name,
                                    email = :email,
                                    phone_number = :phone_number,
                                    address = :address,
                                    salary = :salary,
                                    jobPosition = :jobPosition
                                    WHERE emp_id = :emp_id");

            $stmt->bindParam(':first_name', $_POST['first_name']);
            $stmt->bindParam(':last_name', $_POST['last_name']);
            $stmt->bindParam(':email', $_POST['email']);
            $stmt->bindParam(':phone_number', $_POST['phone_number']);
            $stmt->bindParam(':address', $_POST['address']);
            $stmt->bindParam(':salary', $_POST['salary']);
            $stmt->bindParam(':jobPosition', $_POST['jobPosition']);
            $stmt->bindParam(':emp_id', $_POST['emp_id']);

            if ($stmt->execute()) {
                header('Location: view_employee.php');
                exit;
            } else {
                echo 'Error updating employee: ' . $stmt->errorInfo()[2];
            }
        } else {
            echo 'All fields are required';
        }
    }

} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Employee</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>body {
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
            <li class="nav-item active dropdown ">
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
    <h2>Edit Employee</h2>
    <form method="post">
        <input type="hidden" name="emp_id" value="<?= $employee['emp_id'] ?? '' ?>">
        <div class="form-group">
            <label>First Name:</label>
            <input type="text" class="form-control" name="first_name" value="<?= $employee['first_name'] ?? '' ?>" required>
        </div>
        <div class="form-group">
            <label>Last Name:</label>
            <input type="text" class="form-control" name="last_name" value="<?= $employee['last_name'] ?? '' ?>" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" class="form-control" name="email" value="<?= $employee['email'] ?? '' ?>" required>
        </div>
        <div class="form-group">
            <label>Phone Number:</label>
            <input type="text" class="form-control" name="phone_number" value="<?= $employee['phone_number'] ?? '' ?>">
        </div>
        <div class="form-group">
            <label>Address:</label>
            <textarea class="form-control" name="address"><?= $employee['address'] ?? '' ?></textarea>
        </div>
        <div class="form-group">
            <label>Salary:</label>
            <input type="number" class="form-control" name="salary" value="<?= $employee['salary'] ?? '' ?>" required>
        </div>
        <div class="form-group">
            <label>Job Position:</label>
            <select class="form-control" name="jobPosition" required>
                <option value="VMC Operator" <?= ($employee['jobPosition'] ?? '') == 'VMC Operator' ? 'selected' : '' ?>>VMC Operator</option>
                <option value="Design Engineer" <?= ($employee['jobPosition'] ?? '') == 'Design Engineer' ? 'selected' : '' ?>>Design Engineer</option>
                <option value="Manufacturing Engineer" <?= ($employee['jobPosition'] ?? '') == 'Manufacturing Engineer' ? 'selected' : '' ?>>Manufacturing Engineer</option>
                <option value="Quality Assurance Inspector" <?= ($employee['jobPosition'] ?? '') == 'Quality Assurance Inspector' ? 'selected' : '' ?>>Quality Assurance Inspector</option>
                <option value="Customer Service And Support Specialist" <?= ($employee['jobPosition'] ?? '') == 'Customer Service And Support Specialist' ? 'selected' : '' ?>>Customer Service And Support Specialist</option>
                <option value="Accounting" <?= ($employee['jobPosition'] ?? '') == 'Accounting' ? 'selected' : '' ?>>Accounting</option>
            </select>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update Employee</button>
    </form>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
