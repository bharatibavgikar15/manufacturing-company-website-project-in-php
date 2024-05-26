<?php



$host = 'localhost';
$dbname = 'axesglow';
$username = 'bharati1';
$password = 'arti';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['login_btn'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM employee WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $employee = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($employee && password_verify($password, $employee['login_password'])) {
            // Authentication successful
            session_start();
            $_SESSION['emp_id'] = $employee['emp_id'];
            $_SESSION['first_name'] = $employee['first_name'];
            header('Location: employee_home.php');
        } else {
            // Authentication failed
            echo "<script>alert('Invalid email or password');</script>";
        }
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
</head>
<body>

<div class="login-container">
<a href="login.php" class="back-button"><i class="fas fa-arrow-left"></i></a>
    <h2>Login</h2>
    <form action="employee_login.php" method="post">
        <div class="input-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="input-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="input-group">
            <button type="submit" name="login_btn">Login</button>
        </div>
    </form>
</div>

</body>
</html>
<style>
body {
    font-family: Arial, sans-serif;
    background-image: url('img/background/login_image.jpg'); /* Correct relative path */
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    margin: 0;
    padding: 0;
}

.login-container {
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.input-group {
    margin-bottom: 15px;
}

.input-group label {
    display: block;
    margin-bottom: 8px;
}

.input-group input[type="email"],
.input-group input[type="password"] {
    width: 100%;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
}

.input-group button {
    padding: 10px 15px;
    background-color: #007BFF;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.input-group button:hover {
    background-color: #0056b3;
}

.back-button {
    position: absolute;
    top: 10px;
    left: 10px;
    color: #007BFF;
    text-decoration: none;
    font-size: 20px;
}

.back-button:hover {
    color: #0056b3;
}

</style>