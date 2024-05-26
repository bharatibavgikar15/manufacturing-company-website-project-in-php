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

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        // Delete the employee by ID
        $stmt = $pdo->prepare("DELETE FROM employee WHERE emp_id = :emp_id");
        $stmt->bindParam(':emp_id', $_GET['id']);
        
        if ($stmt->execute()) {
            header('Location: view_employee.php');
            exit;
        } else {
            echo 'Error deleting employee';
        }
    }

} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
