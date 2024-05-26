<?php
// Database connection
$host = 'localhost';
$dbname = 'axesglow';
$username = 'bharati1';
$password = 'arti';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch distinct job positions from the database
    $stmt = $conn->prepare("SELECT DISTINCT jobPosition FROM employee");
    $stmt->execute();

    $jobPositions = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Hardcoded job positions
    $hardcodedPositions = [
        'VMC Operator',
        'Design Engineer',
        'Manufacturing Engineer',
        'Quality Assurance Inspector',
        'Customer Service And Support Specialist',
        'Accounting'
    ];

    // Combine and remove duplicates
    $combinedPositions = array_unique(array_merge($jobPositions, $hardcodedPositions));

    // Generate HTML options
    $options = '';
    foreach ($combinedPositions as $position) {
        $options .= '<option value="' . $position . '">' . $position . '</option>';
    }

    echo $options;

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
