<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $user_type = $_POST["user_type"];
        $username_input = $_POST["username"];
        $password_input = $_POST["password"];

        // Prepare SQL statement
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE user_type = :user_type AND username = :username");
        $stmt->bindParam(':user_type', $user_type);
        $stmt->bindParam(':username', $username_input);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($password_input, $result["password"])) {
            // Start session and set user ID and username
            session_start();
            $_SESSION['userId'] = $result['id'];
            $_SESSION['username'] = $result['username'];

            // Redirect to respective pages based on user type
            switch ($user_type) {
                case 'candidate':
                    header("Location: candidate_page.php");
                    exit();
                case 'customer':
                    header("Location: customer_page.php");
                    exit();
                case 'admin':
                    header("Location: admin_page.php");
                    exit();
                default:
                    echo "Invalid user type!";
                    break;
            }
        } else {
            echo "Invalid credentials!";
        }

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        
        <form action="login.php" method="post">
            <label for="user_type">Select User Type:</label>
            <select name="user_type" id="user_type">
                <option value="candidate">Candidate</option>
                <option value="customer">Customer</option>
                <option value="admin">Admin</option>
            </select>
            
            <label for="username">Email:</label> <!-- Changed "Username" to "Email" -->
            <input type="email" name="username" required> <!-- Changed input type to "email" -->
            
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            
            <button type="submit" class="btn-login">Login</button>
        </form>

        <p>Don't have an account? <a href="/company profile 1/register.php">Register here</a></p>
        <p>Are you an employee here? <a href="employee_login.php">Login here</a></p>
    </div>
   
</body>
</html>
