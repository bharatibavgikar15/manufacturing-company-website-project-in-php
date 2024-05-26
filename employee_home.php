<?php
// Start the session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['emp_id'])) {
    // Redirect to the login page
    header("Location: employee_login.php");
    exit(); // Ensure that no further code is executed after the redirect
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Dashboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
       body {
            font-family: Arial, sans-serif;
            background-image: url('img/background/10.jpg'); /* Ensure the correct relative path to your image */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent background for readability */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add shadow for a better look */
            padding: 10px 0;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent background for readability */
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-top: 80px;
        }

        h1, h2, h3 {
            color: #007bff; /* Adjust color as needed */
        }

        .btn-logout {
            background-color: #dc3545; /* Red color for logout button */
            border-color: #dc3545;
            color: #fff;
        }

        .btn-logout:hover {
            background-color: #c82333; /* Darker red color on hover */
            border-color: #bd2130;
        }

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light ">
        <a class="navbar-brand" href="#">Axes Glow</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active ">
                    <a class="nav-link" href="employee_home.php">Home</a>
                </li>
                <li class="nav-item  ">
                    <a class="nav-link" href="candidates1.php">Candidates</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="orders1.php">Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="enquiries1.php">Enquiries</a>
                </li>
                <li class="nav-item dropdown ">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Message
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="admin_messages.php">View Messages</a>
        <a class="dropdown-item" href="employee_message.php">Send Message</a>
    </div>
</li>
<li class="nav-item">
                <a class="nav-link" href="payments1.php">Payments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="delivery1.php">Deliverey status</a>
            </li>
             

                <li class="nav-item">
                    <a class="nav-link" href="logout1.php" onclick="logout()">Logout</a>
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
        window.location.href = 'logout1.php';
    }

    // Admin dashboard scripts can be added here

</script>

</body>
</html>
