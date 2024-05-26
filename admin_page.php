<?php
// Start the session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['userId'])) {
    // Redirect to the login page
    header("Location: login.php");
    exit(); // Ensure that no further code is executed after the redirect
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-image: url('img/background/6.jpg'); /* Ensure the correct relative path to your image */
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    margin: 0;
    padding: 0;
}
        .container {
            background-color: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1, h2, h3 {
            color: #007bff;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .file-download {
            color: #007bff;
            cursor: pointer;
        }

        .file-download:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Axes Glow</a>
    
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
        <li class="nav-item ">
                <a class="nav-link" href="admin_profile.php">Profile</a>
            </li>
        <li class="nav-item active">
                <a class="nav-link" href="#home">Home</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="candidates.php">Candidates</a>

            </li>
            <li class="nav-item">
                <a class="nav-link" href="orders.php">Orders</a>
            </li>
            <li class="nav-item dropdown ">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Employee
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="employee.php">Add Employee</a>
        <a class="dropdown-item" href="view_employee.php">View Employees</a>
        <a class="dropdown-item" href="attendence.php">Attendence</a>
        <a class="dropdown-item" href="mark_attendence.php">Attendence list</a>
        <div class="dropdown-divider"></div>
        <!-- Removed the Employee Reports option -->
        <!--<a class="dropdown-item" href="#">Employee Reports</a>-->
    </div>
</li>

            <li class="nav-item">
                <a class="nav-link" href="enquiries.php">Enquiries</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="message.php">Message</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="payments.php">Payments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cust_inquiries.php">Customer inquiries</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="delivery.php">Deliverey status</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php" onclick="logout()">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
   <h1 class="text-center">Axes glow</h1>
    <h3>Our Mission & Vision</h3>
    

    <p>
    To provide reliable & cost effective manufacturing solution for global market.
    </p>

    <h3>What We Do</h3>

    <p>
        At Axes Glow, we focus on:
    </p>

    <ul>
        <li><strong>Product Manufacturing:</strong> We manufacture a wide range of [types of products], ensuring superior quality and precision.</li>
        <li><strong>Custom Solutions:</strong> Our team works closely with clients to develop customized manufacturing solutions tailored to their specific needs.</li>
        <li><strong>Quality Assurance:</strong> We adhere to strict quality control standards to ensure that our products meet the highest industry standards.</li>
        <li><strong>Customer Support:</strong> We are committed to providing exceptional customer support, assisting our clients with any inquiries or concerns they may have.</li>
    </ul>
    <h3>About axes glow:</h3>
    <p>
    Axes Glow newly started on 15/12/2012 By Bhojappa Bavgikar currently having more than 25years Machining
experience to our credit. We are located in the MIDC of Bhosari ,Pune - India's bustling Commercial capital city which is a
major well connected by road & rail.
We specialize in Design and machining vmc components like, aluminum components, prototype component machining,
packaging machines parts design and machining, die and mould machining and jigs fixture parts machining
We also offer additional services such as aerospace component development and machining
We also manufacture assemblies enabling our customer's to make one-stop purchases for their requirement.
We take pride in our commitment to quality and on time deliveries and can quite comfortable work even as per simple sketches
or samples of the components.
    </p>
    <!-- Admin dashboard content will go here -->

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function logout() {
        window.location.href = 'logout.php';
    }
</script>

</body>
</html>
