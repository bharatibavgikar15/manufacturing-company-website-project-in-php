<?php
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

$editStatus = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $firstName = htmlspecialchars($_POST['firstName']);
    $middleName = htmlspecialchars($_POST['middleName']);
    $surname = htmlspecialchars($_POST['surname']);
    $address = htmlspecialchars($_POST['address']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $joinImmediately = htmlspecialchars($_POST['joinImmediately']);
    $jobPosition = htmlspecialchars($_POST['jobPosition']);
    
    // File handling
    $target_dir = __DIR__ . "/uploads/";
    $target_file = $target_dir . basename($_FILES["fileInput"]["name"]);
    
    if ($_FILES['fileInput']['size'] > 0) {
        $fileName = htmlspecialchars($_FILES['fileInput']['name']);
    } else {
        $fileName = htmlspecialchars($_POST['oldFile']);
    }

    $stmt = $conn->prepare("UPDATE candidates SET firstName=?, middleName=?, surname=?, address=?, phone=?, email=?, joinImmediately=?, jobPosition=?, fileName=? WHERE id=?");
    $stmt->bind_param("sssssssssi", $firstName, $middleName, $surname, $address, $phone, $email, $joinImmediately, $jobPosition, $fileName, $id);

    if ($stmt->execute()) {
        if ($_FILES['fileInput']['size'] > 0) {
            move_uploaded_file($_FILES["fileInput"]["tmp_name"], $target_file);
        }
        $editStatus = "Record updated successfully";
    } else {
        $editStatus = "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}

$id = $_GET['id'];
$sql = "SELECT * FROM candidates WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    echo "Error: " . $sql . "<br>" . $conn->error;
    exit;
}

$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Candidate</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/vmc.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            background-color: #ffffff;
            margin-top: 50px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        .uploadButton {
            margin-bottom: 10px;
        }

        p {
            margin-top: 10px;
        }

    </style>
</head>

<body>

    <div class="container">
        <h2>Edit Candidate</h2>
        <p><?php echo $editStatus; ?></p>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <input type="hidden" name="oldFile" value="<?php echo $row['fileName']; ?>">
            
            <!-- File Upload -->
            <input type="file" id="fileInput" name="fileInput" accept=".pdf" hidden>
            <label for="fileInput" class="uploadButton chooseFileButton btn btn-primary">Choose File</label>
            <p>Current File: <a href='uploads/<?php echo $row["fileName"]; ?>' target='_blank'><?php echo $row["fileName"]; ?></a></p>
            
            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" class="form-control" value="<?php echo $row['firstName']; ?>" required>
            </div>

            <div class="form-group">
                <label for="middleName">Middle Name:</label>
                <input type="text" id="middleName" name="middleName" class="form-control" value="<?php echo $row['middleName']; ?>" required>
            </div>

            <div class="form-group">
                <label for="surname">Surname:</label>
                <input type="text" id="surname" name="surname" class="form-control" value="<?php echo $row['surname']; ?>" required>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <textarea id="address" class="form-control" name="address" rows="4" required><?php echo $row['address']; ?></textarea>
            </div>

            <div class="form-group">
                <label for="phone">Phone No:</label>
                <input type="tel" id="phone" class="form-control" name="phone" value="<?php echo $row['phone']; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email ID:</label>
                <input type="email" id="email" class="form-control" name="email" value="<?php echo $row['email']; ?>" required>
            </div>

            <div class="form-group">
                <label for="jobPosition">Job Position:</label>
                <select id="jobPosition" class="form-control" name="jobPosition" required>
                    <option value="vmc operator" <?php if($row['jobPosition'] == 'vmc operator') echo 'selected'; ?>>vmc operator</option>
                    <!-- Add more job positions here if needed -->
                </select>
            </div>

            <div class="form-group">
                <label>Are you willing to join immediately?</label><br>
                <input type="radio" id="yes" name="joinImmediately" value="yes" <?php if($row['joinImmediately'] == 'yes') echo 'checked'; ?> required>
                <label for="yes">Yes</label>
                <input type="radio" id="no" name="joinImmediately" value="no" <?php if($row['joinImmediately'] == 'no') echo 'checked'; ?> required>
                <label for="no">No</label>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="vmc.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

</body>

</html>
