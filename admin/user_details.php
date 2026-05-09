<?php
session_start();
require_once '../connection.php';

if(!isset($_SESSION['admin_id'])) {
    header('location: login.php');
    exit();
}

if(!isset($_GET['id'])) {
    header('location: users.php');
    exit();
}

$user_id = mysqli_real_escape_string($con, $_GET['id']);

// Get user details
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_array($result);

if(!$user) {
    header('location: users.php');
    exit();
}

// Get user's orders
$orders_query = "SELECT ui.*, i.name as product_name, i.price as product_price 
                FROM users_items ui 
                JOIN items i ON ui.item_id = i.id 
                WHERE ui.user_id = '$user_id' AND ui.status != 'Added to cart' 
                ORDER BY ui.order_date DESC";
$orders_result = mysqli_query($con, $orders_query);

// Get user's cart items
$cart_query = "SELECT ui.*, i.name as product_name, i.price as product_price 
               FROM users_items ui 
               JOIN items i ON ui.item_id = i.id 
               WHERE ui.user_id = '$user_id' AND ui.status = 'Added to cart'";
$cart_result = mysqli_query($con, $cart_query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            background: url('../img/admin2.jpeg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            padding-bottom: 40px;
            min-height: 100vh;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }
        .navbar {
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            position: relative;
            z-index: 2;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }
        .panel {
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            margin-bottom: 20px;
            border: none;
            background: rgba(255, 255, 255, 0.95);
            transition: transform 0.2s;
        }
        .panel:hover {
            transform: translateY(-2px);
        }
        .panel-heading {
            border-bottom: none;
            padding: 15px 20px;
        }
        .panel-body {
            padding: 20px;
        }
        .panel-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }
        .panel-primary .panel-heading {
            background: #337ab7 !important;
        }
        .table {
            margin-bottom: 0;
            background: white;
        }
        .btn-sm {
            padding: 5px 10px;
        }
        .navbar-brand {
            font-weight: 600;
            font-size: 20px;
        }
        .nav > li > a {
            padding: 15px 20px;
            color: rgba(255,255,255,0.9) !important;
        }
        .nav > li > a:hover {
            background-color: rgba(255,255,255,0.1);
            color: white !important;
        }
        .nav > li.active > a {
            background-color: rgba(255,255,255,0.2) !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Admin Dashboard</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li class="active"><a href="users.php">Users</a></li>
                <li><a href="settings.php">Settings</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">User Details</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Personal Information</h4>
                                <table class="table">
                                    <tr>
                                        <th>Name:</th>
                                        <td><?php echo $user['name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td><?php echo $user['email']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Contact:</th>
                                        <td><?php echo $user['contact']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Address:</th>
                                        <td><?php echo $user['address']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>City:</th>
                                        <td><?php echo $user['city']; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h4>Order History</h4>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                            <th>Order Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($order = mysqli_fetch_array($orders_result)) { ?>
                                        <tr>
                                            <td><?php echo $order['id']; ?></td>
                                            <td><?php echo $order['product_name']; ?></td>
                                            <td><?php echo $order['quantity']; ?></td>
                                            <td>Rs. <?php echo number_format($order['quantity'] * $order['product_price'], 2); ?></td>
                                            <td><?php echo $order['status']; ?></td>
                                            <td><?php echo $order['order_date']; ?></td>
                                            <td>
                                                <a href="order_details.php?id=<?php echo $order['id']; ?>" class="btn btn-info btn-sm">View Details</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h4>Cart Items</h4>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($item = mysqli_fetch_array($cart_result)) { ?>
                                        <tr>
                                            <td><?php echo $item['product_name']; ?></td>
                                            <td><?php echo $item['quantity']; ?></td>
                                                                    <td>Rs. <?php echo $item['product_price']; ?></td>
                        <td>Rs. <?php echo $item['quantity'] * $item['product_price']; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <a href="users.php" class="btn btn-default">Back to Users</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html> 