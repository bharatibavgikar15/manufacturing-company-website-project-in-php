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

    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Fetch form data
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['phoneNumber'] ?? null;
        $address = $_POST['address'] ?? null;
        $salary = $_POST['salary'];
        $loginPassword = password_hash($_POST['loginPassword'], PASSWORD_DEFAULT); // Hash the password
        $jobPosition = $_POST['jobPosition'];

        // Prepare SQL statement to insert data
        $sql = "INSERT INTO employee (first_name, last_name, email, phone_number, address, salary, login_password, jobPosition) 
        VALUES (:firstName, :lastName, :email, :phoneNumber, :address, :salary, :loginPassword, :jobPosition)";

        // Prepare the SQL statement
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':salary', $salary);
        $stmt->bindParam(':loginPassword', $loginPassword);
        $stmt->bindParam(':jobPosition', $jobPosition);

        // Execute the SQL statement
        $stmt->execute();

        echo 'Employee added successfully';
    }

} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
