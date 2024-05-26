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

echo "Connected successfully<br>";

// SQL query to create the 'users' table
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_type VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";

// Execute the users table query
if ($conn->query($sql_users) === TRUE) {
    echo "Table 'users' created successfully<br>";
} else {
    echo "Error creating table 'users': " . $conn->error . "<br>";
}

// SQL query to create the 'enquiries' table
$sql_enquiries = "CREATE TABLE IF NOT EXISTS enquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    message TEXT
)";

// Execute the enquiries table query
if ($conn->query($sql_enquiries) === TRUE) {
    echo "Table 'enquiries' created successfully";
} else {
    echo "Error creating table 'enquiries': " . $conn->error;
}

$sql_candidates = "CREATE TABLE IF NOT EXISTS candidates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(50) NOT NULL,
    middleName VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    address TEXT NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL,
    joinImmediately ENUM('yes', 'no') NOT NULL,
    fileName VARCHAR(255) NOT NULL,
    jobPosition VARCHAR(100) NOT NULL
)";

// Execute the candidates table query
if ($conn->query($sql_candidates) === TRUE) {
    echo "Table 'candidates' created successfully<br>";
} else {
    echo "Error creating table 'candidates': " . $conn->error . "<br>";
}
$sql_orders = "CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT(11) UNSIGNED,
    organizationName VARCHAR(255) NOT NULL,
    product VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    instructions TEXT,
    pdfFile VARCHAR(255),
    additionalFile VARCHAR(255),
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    termsAccepted BOOLEAN NOT NULL,
    advancePay DECIMAL(10, 2),
    paymentStatus ENUM('Done', 'Not Done') NOT NULL,
    status ENUM('Pending', 'Accepted', 'Completed', 'Cancelled') NOT NULL DEFAULT 'Pending',
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES users(id)
);


)";

// Execute the orders table query
if ($conn->query($sql_orders) === TRUE) {
    echo "Table 'orders' created successfully<br>";
} else {
    echo "Error creating table 'orders': " . $conn->error . "<br>";
}


$sql_employee = "CREATE TABLE IF NOT EXISTS employee (
    emp_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) UNSIGNED,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone_number VARCHAR(20),
    address TEXT,
    salary DECIMAL(10, 2) NOT NULL,
    login_password VARCHAR(255) NOT NULL,
    jobPosition VARCHAR(100) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";

// Execute the employee table query
if ($conn->query($sql_employee) === TRUE) {
    echo "Table 'employee' created successfully<br>";
} else {
    echo "Error creating table 'employee': " . $conn->error . "<br>";
}
// Close the connection
$sql_messages="CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message_content TEXT NOT NULL,
    sent_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql_messages) === TRUE) {
    echo "Table 'messages' created successfully<br>";
} else {
    echo "Error creating table 'messages': " . $conn->error . "<br>";
}

$sql_empmessages="CREATE TABLE IF NOT EXISTS empmessages (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    message_con TEXT NOT NULL,
    Sent_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql_empmessages) === TRUE) {
    echo "Table 'empmessages' created successfully<br>";
} else {
    echo "Error creating table 'messages': " . $conn->error . "<br>";
}
$conn->close();
?>
