<?php
// Database connection
$servername = "localhost";
$username = "bharati1";
$password = "arti";
$dbname = "axesglow";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_GET['file'])) {
    $file = $_GET['file'];

    $sql = "SELECT * FROM orders WHERE pdfFile = ? OR additionalFile = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $file, $file);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if($row) {
        $filepath = 'uploads/' . $file;  // Assuming the files are stored in an 'uploads' directory
        if(file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            readfile($filepath);
            exit;
        } else {
            echo "File not found.";
        }
    } else {
        echo "Invalid file.";
    }
}

$conn->close();
?>
