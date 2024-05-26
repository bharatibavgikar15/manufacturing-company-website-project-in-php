<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $user_type = $_POST["user_type"];
        $email = $_POST["username"]; // Use email as username
        $password = $_POST["password"];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if the email already exists
        $checkStmt = $conn->prepare("SELECT id FROM users WHERE username = :email");
        $checkStmt->bindParam(':email', $email);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            echo "Email already exists. Please choose a different email.";
            exit();
        }

        // Prepare SQL statement to insert into users table
        $stmt = $conn->prepare("INSERT INTO users (user_type, username, password) VALUES (:user_type, :email, :password)");
        $stmt->bindParam(':user_type', $user_type);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        
        if ($stmt->execute()) {
            // Get the last inserted ID (userId)
            $userId = $conn->lastInsertId();
            
            // Insert userId into candidates table
            $insertStmt = $conn->prepare("INSERT INTO candidates (userId, email) VALUES (:userId, :email)");
            $insertStmt->bindParam(':userId', $userId);
            $insertStmt->bindParam(':email', $email);
            $insertStmt->execute();

            echo "Registration successful!";
        } else {
            echo "Error: Unable to register. Please try again.";
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
    <title>Registration Page</title>
   
    <style>
    /* Body styles with background image */
   /* Body styles with background image */
body {
    font-family: Arial, sans-serif;
    background-image: url('img/background/login_image.jpg'); /* Ensure the correct relative path to your image */
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    margin: 0;
    padding: 0;
}

/* Registration container styles */
.register-container {
    max-width: 400px;
    margin: 100px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent background for readability */
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.register-container h2 {
    margin-bottom: 20px;
    color: #333;
}

/* Form styles */
label {
    display: block;
    margin-bottom: 8px;
    color: #555;
    text-align: left; /* Align text to the left for better readability */
}

input[type="text"],
input[type="password"],
input[type="email"], /* Added email input styling */
select {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box; /* Ensure padding is included in the total width */
}

/* Email input specific styles */
input[type="email"] {
    background-color: #f9f9f9;
    border-color: #ccc;
    font-size: 14px;
    color: #333;
}

button.btn-register {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 4px;
    background-color: #28a745; /* Green color for the button */
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button.btn-register:hover {
    background-color: #218838; /* Darker green for hover effect */
}

p {
    margin-top: 20px;
}

a {
    color: #007BFF;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
</style>
    
</head>
<body>
    <div class="register-container">
        <h2>Registration</h2>
        
        <form action="register.php" method="post" onsubmit="return validateForm()">
            <label for="user_type">Select User Type:</label>
            <select name="user_type" id="user_type">
                <option value="candidate">Candidate</option>
                <option value="customer">Customer</option>
            </select>
            
            <label for="username">Email:</label>
            <input type="email" name="username" id="username" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            
            <button type="submit" class="btn-register">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>

    <script>
        function validateForm() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;

            if (password != confirmPassword) {
                alert("Passwords do not match!");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
