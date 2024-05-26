<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['userId'])) {
    header("location: login.php");
    exit();
}

include 'db_connect.php';

$userId = $_SESSION['userId'];

// Fetch candidate details
try {
    $stmt = $conn->prepare("SELECT * FROM candidates WHERE userId = :userId");
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();

    $candidate = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Careers Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
      body {
    font-family: Arial, sans-serif;
    background-image: url('img/background/2.jpg'); /* Ensure the correct relative path to your image */
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    margin: 0;
    padding: 0;
}


.header {
    background-color: rgba(0, 123, 255, 0.9); /* Semi-transparent background for readability */
    color: #fff;
    padding: 20px;
    text-align: center;
    margin-bottom: 20px;
    border-radius: 5px;
}

.card {
    margin-bottom: 20px;
}

.card-header {
    background-color: #17a2b8;
    color: #fff;
}

.btn-primary {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-primary:hover {
    background-color: #218838;
    border-color: #1e7e34;
}

.navbar {
    background-color: rgba(51, 51, 51, 0.8); /* Semi-transparent navbar background */
    padding: 10px;
}

.navbar-brand,
.navbar-nav .nav-link {
    color: #fff;
}

.navbar-brand:hover,
.navbar-nav .nav-link:hover {
    color: #007bff;
}
</style>
</head>

<body>

<<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
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
<div class="container-fluid">
    <div class="row">
        <!-- Main Content -->
        <div class="col-md-12">
            <div class="header">
                <h1>Join Our Team!</h1>
                <p>We are looking for talented individuals to join our growing team.</p>
            </div>

            <div class="row">
                <!-- Additional Careers -->
                <?php
                $careers = [
                    ['title' => 'VMC Operator', 'description' => 'We are seeking a VMC operator to operate vertical machining centers.', 'link' => 'vmc.php'],
                    ['title' => 'Design Engineer', 'description' => 'We are looking for a design engineer to create innovative designs.', 'link' => 'design_engineer.php'],
                    ['title' => 'Manufacturing Engineer', 'description' => 'We are seeking a manufacturing engineer to improve production processes.', 'link' => 'manufacturing_engineer.php'],
                    ['title' => 'Quality Assurance Inspector', 'description' => 'We are looking for a quality assurance inspector to ensure product quality.', 'link' => 'quality_assurance.php'],
                    ['title' => 'Customer Service And Support Specialist', 'description' => 'We are seeking a customer service and support specialist to assist our clients.', 'link' => 'customer_service.php'],
                    ['title' => 'Accounting', 'description' => 'We are looking for an accounting professional to manage financial records.', 'link' => 'accounting.php']
                ];

                foreach ($careers as $career) {
                    echo '
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>' . $career['title'] . '</h4>
                            </div>
                            <div class="card-body">
                                <p>' . $career['description'] . '</p>
                                <a href="' . $career['link'] . '" class="btn btn-primary">Apply Now</a>
                            </div>
                        </div>
                    </div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
