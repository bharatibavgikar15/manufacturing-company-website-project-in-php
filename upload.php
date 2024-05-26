<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$dbname = 'axesglow';
$username = 'bharati1';
$password = 'arti';

// Create a new mysqli connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$uploadStatus = "";

// Check if form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get and sanitize form data
    $firstName = isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : '';
    $middleName = isset($_POST['middleName']) ? htmlspecialchars($_POST['middleName']) : '';
    $surname = isset($_POST['surname']) ? htmlspecialchars($_POST['surname']) : '';
    $address = isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '';
    $phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $joinImmediately = isset($_POST['joinImmediately']) ? htmlspecialchars($_POST['joinImmediately']) : '';
    $jobPosition = isset($_POST['jobPosition']) ? htmlspecialchars($_POST['jobPosition']) : '';
    
    $userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : 0;
    if ($userId == 0) {
        echo "Error: User not logged in or session expired.";
        exit;
    }
    
    // File upload handling
    if(isset($_FILES['fileInput'])) {
        // Validate file
        $uploadOk = validateFile($_FILES['fileInput']);
        
        if ($uploadOk) {
            $fileName = htmlspecialchars($_FILES['fileInput']['name']);
            $target_file = __DIR__ . "/uploads/" . $fileName;
            
            if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $target_file)) {
                // Insert data into candidates table
                $sql = "INSERT INTO candidates (userId, firstName, middleName, surname, address, phone, email, joinImmediately, fileName, jobPosition) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("isssssssss", $userId, $firstName, $middleName, $surname, $address, $phone, $email, $joinImmediately, $fileName, $jobPosition);
                
                if ($stmt->execute()) {
                    $uploadStatus = "New record created successfully";
                } else {
                    $uploadStatus = "Error: " . $stmt->error;
                }
                
            } else {
                $uploadStatus = "Sorry, there was an error uploading your file.";
            }
        } else {
            $uploadStatus = "File upload validation failed.";
        }
    } else {
        $uploadStatus = "File not uploaded.";
    }

    $stmt->close();
}

// Function to validate file
function validateFile($file) {
    $uploadOk = 1;
    $target_dir = __DIR__ . "/uploads/";
    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    
    // Check file size
    if ($file["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    
    // Allow only pdf files
    if ($imageFileType != "pdf") {
        echo "Sorry, only PDF files are allowed.";
        $uploadOk = 0;
    }
    
    return $uploadOk;
}

// Fetch candidates data
$sql = "SELECT * FROM candidates WHERE userId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<p><?php echo $uploadStatus; ?></p>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["firstName"] . "</td>";
        echo "<td>" . $row["middleName"] . "</td>";
        echo "<td>" . $row["surname"] . "</td>";
        echo "<td>" . $row["address"] . "</td>";
        echo "<td>" . $row["phone"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["joinImmediately"] . "</td>";
        echo "<td><a href='uploads/" . $row["fileName"] . "' target='_blank'>" . $row["fileName"] . "</a></td>";
        echo "<td>" . $row["jobPosition"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No records found.</td></tr>";
}

$stmt->close();
$conn->close();
?>
