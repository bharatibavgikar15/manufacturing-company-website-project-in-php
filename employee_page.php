<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Dashboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
            color: #333;
            font-family: 'Arial', sans-serif;
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
    <a class="navbar-brand" href="#">Employee Dashboard</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
        <li class="nav-item ">
                <a class="nav-link" href="employee_home.php">Home</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="employee_page.php">Candidates</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="orders.php">Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="enquiries.php">Enquiries</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="text-center">Employee Dashboard</h1>

    <div class="table-responsive mt-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Organization Name</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Instructions</th>
                    <th>PDF File</th>
                    <th>Additional File</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Terms Accepted</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="orderTableBody">
                <!-- Order details will be populated here -->
            </tbody>
        </table>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Fetch customer orders from customer_page.php
    function fetchOrders() {
        $.ajax({
            url: 'customer_page.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                populateOrders(data);
            },
            error: function(error) {
                console.error('Error fetching orders:', error);
            }
        });
    }

    // Populate order details in the table
    function populateOrders(orders) {
        const tableBody = document.getElementById('orderTableBody');
        let html = '';
        orders.forEach(order => {
            html += `
                <tr>
                    <td>${order.id}</td>
                    <td>${order.organizationName}</td>
                    <td>${order.product}</td>
                    <td>${order.quantity}</td>
                    <td>${order.instructions}</td>
                    <td><a href="uploads/${order.pdfFile}" class="file-download" download>${order.pdfFile}</a></td>
                    <td><a href="uploads/${order.additionalFile}" class="file-download" download>${order.additionalFile}</a></td>
                    <td>${order.name}</td>
                    <td>${order.email}</td>
                    <td>${order.phone}</td>
                    <td>${order.address}</td>
                    <td>${order.termsAccepted ? 'Yes' : 'No'}</td>
                    <td><button class="btn btn-primary" onclick="editOrder(${order.id})">Edit</button> | <button class="btn btn-danger" onclick="deleteOrder(${order.id})">Delete</button></td>
                </tr>
            `;
        });
        tableBody.innerHTML = html;
    }

    // Function to edit order (Replace with actual edit functionality)
    function editOrder(id) {
        alert('Edit order with ID: ' + id);
    }

    // Function to delete order (Replace with actual delete functionality)
    function deleteOrder(id, email) {
        if (confirm('Are you sure you want to delete this order?')) {
            $.ajax({
                url: 'delete_order.php',
                method: 'POST',
                data: { id: id, email: email },
                success: function(response) {
                    if (response.success) {
                        fetchOrders();  // Refresh order list
                        alert('Order deleted successfully and customer notified.');
                    } else {
                        alert('Error deleting order.');
                    }
                },
                error: function(error) {
                    console.error('Error deleting order:', error);
                    alert('Error deleting order.');
                }
            });
        }
    }

    // Populate orders on page load
    fetchOrders();

</script>

</body>
</html>
