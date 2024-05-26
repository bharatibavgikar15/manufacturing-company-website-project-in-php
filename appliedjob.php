

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applied Jobs</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f4f4f4;
            color: #333;
            font-family: Arial, sans-serif;
        }

        .header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            text-align: center;
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

        .sidebar {
            background-color: #333;
            color: #fff;
            padding: 15px;
            height: 500vh;
        }

        .sidebar a {
            display: block;
            margin-bottom: 15px;
            color: #fff;
            text-decoration: none;
        }

        .sidebar a.my-profile {
            background-color: #6c757d;
            padding: 10px;
            border-radius: 5px;
        }

        .sidebar a:hover {
            color: #007bff;
        }
    </style>
</head>

<body>

    <div class="container-fluid">

        <div class="row">

            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
                <h2>Dashboard</h2>
                <a href="myprofile.php" >my profile</a>
                <a href="candidate_page.php">Careers</a>
                <a href="appliedjob.php">Applied Jobs</a>
                <a href="logout.php">Logout</a>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">

                <div class="header">
                    <h1>Applied Jobs</h1>
                    <p>Below is the list of jobs you have applied for.</p>
                </div>

                <div class="row">
                    <!-- List of Applied Jobs -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>VMC Operator</h4>
                            </div>
                            <div class="card-body">
                            <?php
// Database connection
$host = 'localhost';
$dbname = 'axesglow';
$username = 'bharati1';
$password = 'arti';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you have a session variable named 'userId' that holds the ID of the logged-in user
// This should be set after a successful login
if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];

// Prepare and execute SQL queries
$jobs = [
    'vmc operator',
    'design engineer',
    'manufacturing engineer',
    'quality assurance',
    'customer service and support specialist',
    'accounting'
];

foreach ($jobs as $job) {
    $sql = "SELECT * FROM candidates WHERE userId = ? AND jobPosition = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("is", $userId, $job);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<div class='card'>";
            echo "<div class='card-header'>";
            echo "<h4>" . ucwords($job) . "</h4>";
            echo "</div>";
            echo "<div class='card-body'>";
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>First Name</th><th>Middle Name</th><th>Surname</th><th>Address</th><th>Phone</th><th>Email</th><th>Join Immediately</th><th>File Name</th><th>Job Position</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["firstName"] . "</td>";
                echo "<td>" . $row["middleName"] . "</td>";
                echo "<td>" . $row["surname"] . "</td>";
                echo "<td>" . $row["address"] . "</td>";
                echo "<td>" . $row["phone"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["joinImmediately"] . "</td>";
                echo "<td>" . $row["fileName"] . "</td>";
                echo "<td>" . $row["jobPosition"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "<p>Status: <span id='status" . str_replace(' ', '', ucwords($job)) . "'>Pending</span></p>";
            echo "<a href='" . strtolower($job) . "_job.php?jobTitle=" . ucwords($job) . "' class='btn btn-primary'>View</a>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "<div class='card'>";
            echo "<div class='card-header'>";
            echo "<h4>" . ucwords($job) . "</h4>";
            echo "</div>";
            echo "<div class='card-body'>";
            echo "0 results";
            echo "</div>";
            echo "</div>";
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}
}


?>

                               
                                
                                <p>Status: <span id="statusDesign">Accepted</span></p>
                                
                                <a href="design_job.php?jobTitle=Design Engineer" class="btn btn-primary">View</a>                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4>Manufacturing engineer</h4>
                            </div>
                            <div class="card-body">
                            
                                <?php
                                $host = 'localhost';
                                $dbname = 'axesglow';
                                $username = 'bharati1';
                                $password = 'arti';
                                
                                $conn = new mysqli($host, $username, $password, $dbname);
                                
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }
                                
                                // Assuming you have a session variable named 'userId' that holds the ID of the logged-in user
                                // This should be set after a successful login
                                if (isset($_SESSION['userId'])) {
                                    $userId = $_SESSION['userId'];
                                
                                // Prepare and execute SQL queries
                                $jobs = [
                                    'vmc operator',
                                    'design engineer',
                                    'manufacturing engineer',
                                    'quality assurance',
                                    'customer service and support specialist',
                                    'accounting'
                                ];
                                
                                foreach ($jobs as $job) {
                                    $sql = "SELECT * FROM candidates WHERE userId = ? AND jobPosition = ?";
                                    $stmt = $conn->prepare($sql);
                                
                                    if ($stmt) {
                                        $stmt->bind_param("is", $userId, $job);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                
                                        if ($result->num_rows > 0) {
                                            echo "<div class='card'>";
                                            echo "<div class='card-header'>";
                                            echo "<h4>" . ucwords($job) . "</h4>";
                                            echo "</div>";
                                            echo "<div class='card-body'>";
                                            echo "<table border='1'>";
                                            echo "<tr><th>ID</th><th>First Name</th><th>Middle Name</th><th>Surname</th><th>Address</th><th>Phone</th><th>Email</th><th>Join Immediately</th><th>File Name</th><th>Job Position</th></tr>";
                                
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $row["id"] . "</td>";
                                                echo "<td>" . $row["firstName"] . "</td>";
                                                echo "<td>" . $row["middleName"] . "</td>";
                                                echo "<td>" . $row["surname"] . "</td>";
                                                echo "<td>" . $row["address"] . "</td>";
                                                echo "<td>" . $row["phone"] . "</td>";
                                                echo "<td>" . $row["email"] . "</td>";
                                                echo "<td>" . $row["joinImmediately"] . "</td>";
                                                echo "<td>" . $row["fileName"] . "</td>";
                                                echo "<td>" . $row["jobPosition"] . "</td>";
                                                echo "</tr>";
                                            }
                                
                                            echo "</table>";
                                            echo "<p>Status: <span id='status" . str_replace(' ', '', ucwords($job)) . "'>Pending</span></p>";
                                            echo "<a href='" . strtolower($job) . "_job.php?jobTitle=" . ucwords($job) . "' class='btn btn-primary'>View</a>";
                                            echo "</div>";
                                            echo "</div>";
                                        } else {
                                            echo "<div class='card'>";
                                            echo "<div class='card-header'>";
                                            echo "<h4>" . ucwords($job) . "</h4>";
                                            echo "</div>";
                                            echo "<div class='card-body'>";
                                            echo "0 results";
                                            echo "</div>";
                                            echo "</div>";
                                        }
                                
                                        $stmt->close();
                                    } else {
                                        echo "Error: " . $conn->error;
                                    }
                                }
                                }
                                
                                
                                ?>
                                
                                
                                <p>Status: <span id="statusManufacturing">Accepted</span></p>
                                
                                <a href="manufacturing_job.php?jobTitle=Manufacturing engineer" class="btn btn-primary">View</a>

                                </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4>Quality Assurance</h4>
                            </div>
                            <div class="card-body">
                            <?php
                                // Database connection
                                $host = 'localhost';
                                $dbname = 'axesglow';
                                $username = 'bharati1';
                                $password = 'arti';
                                
                                $conn = new mysqli($host, $username, $password, $dbname);
                                
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }
                                
                                // Assuming you have a session variable named 'userId' that holds the ID of the logged-in user
                                // This should be set after a successful login
                                if (isset($_SESSION['userId'])) {
                                    $userId = $_SESSION['userId'];
                                
                                // Prepare and execute SQL queries
                                $jobs = [
                                    'vmc operator',
                                    'design engineer',
                                    'manufacturing engineer',
                                    'quality assurance',
                                    'customer service and support specialist',
                                    'accounting'
                                ];
                                
                                foreach ($jobs as $job) {
                                    $sql = "SELECT * FROM candidates WHERE userId = ? AND jobPosition = ?";
                                    $stmt = $conn->prepare($sql);
                                
                                    if ($stmt) {
                                        $stmt->bind_param("is", $userId, $job);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                
                                        if ($result->num_rows > 0) {
                                            echo "<div class='card'>";
                                            echo "<div class='card-header'>";
                                            echo "<h4>" . ucwords($job) . "</h4>";
                                            echo "</div>";
                                            echo "<div class='card-body'>";
                                            echo "<table border='1'>";
                                            echo "<tr><th>ID</th><th>First Name</th><th>Middle Name</th><th>Surname</th><th>Address</th><th>Phone</th><th>Email</th><th>Join Immediately</th><th>File Name</th><th>Job Position</th></tr>";
                                
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $row["id"] . "</td>";
                                                echo "<td>" . $row["firstName"] . "</td>";
                                                echo "<td>" . $row["middleName"] . "</td>";
                                                echo "<td>" . $row["surname"] . "</td>";
                                                echo "<td>" . $row["address"] . "</td>";
                                                echo "<td>" . $row["phone"] . "</td>";
                                                echo "<td>" . $row["email"] . "</td>";
                                                echo "<td>" . $row["joinImmediately"] . "</td>";
                                                echo "<td>" . $row["fileName"] . "</td>";
                                                echo "<td>" . $row["jobPosition"] . "</td>";
                                                echo "</tr>";
                                            }
                                
                                            echo "</table>";
                                            echo "<p>Status: <span id='status" . str_replace(' ', '', ucwords($job)) . "'>Pending</span></p>";
                                            echo "<a href='" . strtolower($job) . "_job.php?jobTitle=" . ucwords($job) . "' class='btn btn-primary'>View</a>";
                                            echo "</div>";
                                            echo "</div>";
                                        } else {
                                            echo "<div class='card'>";
                                            echo "<div class='card-header'>";
                                            echo "<h4>" . ucwords($job) . "</h4>";
                                            echo "</div>";
                                            echo "<div class='card-body'>";
                                            echo "0 results";
                                            echo "</div>";
                                            echo "</div>";
                                        }
                                
                                        $stmt->close();
                                    } else {
                                        echo "Error: " . $conn->error;
                                    }
                                }
                                }
                                
                                
                                ?>
                                <p>Status: <span id="statusQA">Accepted</span></p>
                                
                                <a href="quality_job.php?jobTitle=Quality Assurance" class="btn btn-primary">View</a>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4>Customer Service And Support Specialist</h4>
                            </div>
                            <div class="card-body">
                            <?php
                                // Database connection
                                $host = 'localhost';
                                $dbname = 'axesglow';
                                $username = 'bharati1';
                                $password = 'arti';

                                $conn = new mysqli($host, $username, $password, $dbname);

                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Execute SQL query to show tables
                                $sql = "SELECT * FROM candidates WHERE jobPosition = 'Customer Service And Support Specialist'";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    echo "<table border='1'>";
                                    echo "<tr><th>ID</th><th>First Name</th><th>Middle Name</th><th>Surname</th><th>Address</th><th>Phone</th><th>Email</th><th>Join Immediately</th><th>File Name</th><th>Job Position</th></tr>";
    
                                    while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["id"] . "</td>";
                                    echo "<td>" . $row["firstName"] . "</td>";
                                    echo "<td>" . $row["middleName"] . "</td>";
                                    echo "<td>" . $row["surname"] . "</td>";
                                    echo "<td>" . $row["address"] . "</td>";
                                    echo "<td>" . $row["phone"] . "</td>";
                                    echo "<td>" . $row["email"] . "</td>";
                                    echo "<td>" . $row["joinImmediately"] . "</td>";
                                    echo "<td>" . $row["fileName"] . "</td>";
                                    echo "<td>" . $row["jobPosition"] . "</td>";
                                   echo "</tr>";
                                    }
    
                                    echo "</table>";
                                    } else {
                                       echo "0 results";
                                    }

                                $conn->close();
                                ?>
                                
                                <p>Status: <span id="statusCustomerService">Accepted</span></p>
                                
                                <a href="customerservice_job.php?jobTitle=Customer Service And Support Specialist" class="btn btn-primary">View</a>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4>Accounting</h4>
                            </div>
                            <div class="card-body">
                            <?php
                                // Database connection
                                $host = 'localhost';
                                $dbname = 'axesglow';
                                $username = 'bharati1';
                                $password = 'arti';

                                $conn = new mysqli($host, $username, $password, $dbname);

                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Execute SQL query to show tables
                                

                                $sql = "SELECT * FROM candidates WHERE userId = ? AND jobPosition = 'vmc operator'";
                                $stmt = $conn->prepare($sql);
                                $result = $conn->query($sql);

                                if ($stmt) {
                                    $stmt->bind_param("i", $userId);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                    echo "<table border='1'>";
                                    echo "<tr><th>ID</th><th>First Name</th><th>Middle Name</th><th>Surname</th><th>Address</th><th>Phone</th><th>Email</th><th>Join Immediately</th><th>File Name</th><th>Job Position</th></tr>";
    
                                    while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["id"] . "</td>";
                                    echo "<td>" . $row["firstName"] . "</td>";
                                    echo "<td>" . $row["middleName"] . "</td>";
                                    echo "<td>" . $row["surname"] . "</td>";
                                    echo "<td>" . $row["address"] . "</td>";
                                    echo "<td>" . $row["phone"] . "</td>";
                                    echo "<td>" . $row["email"] . "</td>";
                                    echo "<td>" . $row["joinImmediately"] . "</td>";
                                    echo "<td>" . $row["fileName"] . "</td>";
                                    echo "<td>" . $row["jobPosition"] . "</td>";
                                   echo "</tr>";
                                    }
    
                                    echo "</table>";
                                    } else {
                                       echo "0 results";
                                    }
                                }
                                $conn->close();
                                ?>
                            
                                <p>Status: <span id="statusAccounting">Accepted</span></p>
                                
                                <a href="Accounting_job.php?jobTitle=Accountingt" class="btn btn-primary">View</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function editJob(jobTitle) {
            // You can navigate to an edit page or show a modal for editing here
            alert("Editing " + jobTitle);
        }

        function deleteJob(jobTitle) {
            // Logic to delete the job
            alert("Deleting " + jobTitle);
        }

        // Logic to check job status and update accordingly
        function checkJobStatus() {
            let jobs = {
                'VMC Operator': 'Pending',
                'Design Engineer': 'Accepted',
                'Manufacturing engineer': 'Accepted',
                'Quality Assurance': 'Accepted',
                'Customer Service And Support Specialist': 'Accepted',
                'Accounting': 'Accepted'
            };

            for(let job in jobs) {
                let status = jobs[job];
                if(status === 'Accepted') {
                    document.getElementById("status" + job.replace(/\s+/g, '')).innerText = "Accepted";
                } else {
                    document.getElementById("status" + job.replace(/\s+/g, '')).innerText = "Pending";
                }
            }
        }

        // Call the function to check job status
        checkJobStatus();
    </script>

</body>

</html>
