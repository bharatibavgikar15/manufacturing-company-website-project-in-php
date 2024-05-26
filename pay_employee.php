<?php
// Database connection
$host = 'localhost';
$dbname = 'axesglow';
$username = 'bharati1';
$password = 'arti';

$paymentNotification = ''; // Notification variable

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id'])) {
        $emp_id = $_GET['id'];

        // Fetch employee details from the database
        $stmt = $pdo->prepare("SELECT * FROM employee WHERE emp_id = :emp_id");
        $stmt->bindParam(':emp_id', $emp_id, PDO::PARAM_INT);
        $stmt->execute();
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$employee) {
            echo "Employee not found.";
            exit;
        }
    } else {
        echo "Invalid request.";
        exit;
    }

    // If the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $bonus = isset($_POST['bonus']) ? floatval($_POST['bonus']) : 0.0;
        $salary = isset($_POST['salary']) ? floatval($_POST['salary']) : floatval($employee['salary']);
        $totalPayment = $salary + $bonus;

        // Insert the payment record into the payments table
        $stmt = $pdo->prepare("INSERT INTO payments (empid, amount, bonus) VALUES (:emp_id, :amount, :bonus)");
        $stmt->bindParam(':emp_id', $emp_id, PDO::PARAM_INT);
        $stmt->bindParam(':amount', $totalPayment);
        $stmt->bindParam(':bonus', $bonus);
        $stmt->execute();

        // Set notification for successful payment
        $paymentNotification = '<div class="alert alert-success">Payment processed successfully!</div>';

        // Redirect to the employee list page with a success message
        header('Location: view_employee.php?payment=success&amount=' . $totalPayment);
        exit;
    }

} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pay Employee</title>
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

        .payment-notification {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #dff0d8; /* Success notification background color */
            border: 1px solid #c3e6cb; /* Success notification border color */
            color: #3c763d; /* Success notification text color */
            border-radius: 4px;
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
    <h2>Pay Employee</h2>
    <!-- Display Payment Notification -->
    <?= $paymentNotification ?>

    <form method="post">
        <div class="form-group">
            <label for="empName">Employee Name</label>
            <input type="text" class="form-control" id="empName" value="<?= htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']) ?>" readonly>
        </div>
        <div class="form-group">
            <label for="empSalary">Salary</label>
            <input type="number" class="form-control" id="empSalary" name="salary" value="<?= htmlspecialchars($employee['salary']) ?>" step="0.01" placeholder="Enter salary">
        </div>
        <div class="form-group">
            <label for="bonus">Bonus</label>
            <input type="number" class="form-control" id="bonus" name="bonus" step="0.01" placeholder="Enter bonus amount">
        </div>
        <button type="submit" class="btn btn-success">Confirm Payment</button>
        <a href="view_employee.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
