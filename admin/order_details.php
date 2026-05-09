<?php
session_start();
require_once '../connection.php';

if(!isset($_SESSION['admin_id'])) {
    header('location: login.php');
    exit();
}

if(!isset($_GET['id'])) {
    header('location: orders.php');
    exit();
}

$order_id = mysqli_real_escape_string($con, $_GET['id']);

// Get order details
$query = "SELECT ui.*, u.name as user_name, u.email as user_email, u.contact as user_contact, 
          u.city as user_city, u.address as user_address, i.name as product_name, 
          i.price as product_price, (i.price * ui.quantity) as total_amount
          FROM users_items ui 
          JOIN users u ON ui.user_id = u.id 
          JOIN items i ON ui.item_id = i.id 
          WHERE ui.id = '$order_id' AND ui.status != 'Added to cart'";
$result = mysqli_query($con, $query);
$order = mysqli_fetch_array($result);

if(!$order) {
    header('location: orders.php');
    exit();
}

// Get order tracking history
$tracking_query = "SELECT * FROM order_tracking WHERE order_id = '$order_id' ORDER BY created_at DESC";
$tracking_result = mysqli_query($con, $tracking_query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Order Details</title>
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
        .order-info {
            margin-bottom: 20px;
        }
        .order-info h4 {
            color: #333;
            margin-bottom: 15px;
        }
        .order-info p {
            margin-bottom: 5px;
        }
        .order-info strong {
            color: #555;
        }
        .tracking-timeline {
            position: relative;
            padding-left: 30px;
            margin-top: 20px;
        }
        .tracking-timeline:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #ddd;
        }
        .tracking-item {
            position: relative;
            margin-bottom: 20px;
        }
        .tracking-item:before {
            content: '';
            position: absolute;
            left: -34px;
            top: 0;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #337ab7;
            border: 2px solid #fff;
        }
        .tracking-date {
            color: #666;
            font-size: 12px;
        }
        .tracking-status {
            color: #333;
            font-weight: 600;
            margin: 5px 0;
        }
        .tracking-notes {
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Shopingo Admin</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="products.php">Products</a></li>
                <li class="active"><a href="orders.php">Orders</a></li>
                <li><a href="users.php">Users</a></li>
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
                        <h3 class="panel-title">Order Details #<?php echo $order_id; ?></h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="order-info">
                                    <h4>Customer Information</h4>
                                    <p><strong>Name:</strong> <?php echo $order['user_name']; ?></p>
                                    <p><strong>Email:</strong> <?php echo $order['user_email']; ?></p>
                                    <p><strong>Contact:</strong> <?php echo $order['user_contact']; ?></p>
                                    <p><strong>City:</strong> <?php echo $order['user_city']; ?></p>
                                    <p><strong>Address:</strong> <?php echo $order['user_address']; ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="order-info">
                                    <h4>Order Information</h4>
                                    <p><strong>Order Date:</strong> <?php echo $order['order_date']; ?></p>
                                    <p><strong>Product:</strong> <?php echo $order['product_name']; ?></p>
                                    <p><strong>Quantity:</strong> <?php echo $order['quantity']; ?></p>
                                                            <p><strong>Price per Unit:</strong> Rs. <?php echo number_format($order['product_price'], 2); ?></p>
                        <p><strong>Total Amount:</strong> Rs. <?php echo number_format($order['total_amount'], 2); ?></p>
                                    <p><strong>Status:</strong> <?php echo $order['status']; ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="order-info">
                                    <h4>Order Status History</h4>
                                    <div class="tracking-timeline">
                                        <?php while($tracking = mysqli_fetch_array($tracking_result)) { ?>
                                        <div class="tracking-item">
                                            <div class="tracking-date"><?php echo $tracking['created_at']; ?></div>
                                            <div class="tracking-status"><?php echo $tracking['status']; ?></div>
                                            <?php if($tracking['notes']) { ?>
                                            <div class="tracking-notes"><?php echo $tracking['notes']; ?></div>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <a href="orders.php" class="btn btn-default">Back to Orders</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
       <div class="container">
        <center>
           <p>Copyright © 2025 Alisha Sajjad</p>
       </center>
       </div>
   </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html> 