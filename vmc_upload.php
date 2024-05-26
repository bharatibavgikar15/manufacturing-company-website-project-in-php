<?php
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
    
    // File upload handling
    if(isset($_FILES['fileInput'])) {
        switch ($_FILES['fileInput']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                echo 'No file sent.';
                exit;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                echo 'Exceeded filesize limit.';
                exit;
            case UPLOAD_ERR_PARTIAL:
                echo 'Partial upload.';
                exit;
            case UPLOAD_ERR_NO_TMP_DIR:
                echo 'No temporary directory.';
                exit;
            case UPLOAD_ERR_CANT_WRITE:
                echo 'Cannot write to disk.';
                exit;
            case UPLOAD_ERR_EXTENSION:
                echo 'File upload stopped by extension.';
                exit;
            default:
                echo 'Unknown errors.';
                exit;
        }

        // Absolute path to uploads directory
        $target_dir = __DIR__ . "/uploads/";
        $target_file = $target_dir . basename($_FILES["fileInput"]["name"]);

        // Check if the directory exists, if not create it
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        
        // Check file size (assuming you want to limit to 5MB)
        if ($_FILES["fileInput"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        
        // Allow only pdf files
        if($imageFileType != "pdf") {
            echo "Sorry, only PDF files are allowed.";
            $uploadOk = 0;
        }
        
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["fileInput"]["name"])). " has been uploaded.";
                
                // Insert data into candidates table
                $fileName = htmlspecialchars($_FILES['fileInput']['name']);
                
                $sql = "INSERT INTO candidates (firstName, middleName, surname, address, phone, email, joinImmediately, fileName, `jobPosition`) VALUES ('$firstName', '$middleName', '$surname', '$address', '$phone', '$email', '$joinImmediately', '$fileName', '$jobPosition')";

                $result = $conn->query($sql);

                if (!$result) {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                    exit;
                } else {
                    echo "New record created successfully";
                }
                
            } else {
                $uploadStatus = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $uploadStatus = "File not uploaded.";
    }
}

// Fetch candidates data
$sql = "SELECT * FROM candidates WHERE `jobPosition` = 'vmc operator'";
$result = $conn->query($sql);

if (!$result) {
    echo "Error: " . $sql . "<br>" . $conn->error;
    exit;
}

?>

<p><?php echo $uploadStatus; ?></p>
<h2>Uploaded Candidates</h2>

<table>
    <thead>
        <tr>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Surname</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Join Immediately</th>
            <th>File Name</th>
            <th>Job Position</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
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
            echo "<tr><td colspan='9'>No records found.</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
// Close the connection
$conn->close();
?>
