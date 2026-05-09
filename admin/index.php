<?php
session_start();
require_once '../connection.php';

if(!isset($_SESSION['admin_id'])) {
    header('location: login.php');
    exit();
}

// Get total users
$users_query = "SELECT COUNT(*) as total_users FROM users";
$users_result = mysqli_query($con, $users_query);
$total_users = mysqli_fetch_array($users_result)['total_users'];

// Get total products
$products_query = "SELECT COUNT(*) as total_products FROM items";
$products_result = mysqli_query($con, $products_query);
$total_products = mysqli_fetch_array($products_result)['total_products'];

// Get total orders
$orders_query = "SELECT COUNT(*) as total_orders FROM users_items WHERE status != 'Added to cart'";
$orders_result = mysqli_query($con, $orders_query);
$total_orders = mysqli_fetch_array($orders_result)['total_orders'];

// Get recent orders
$recent_orders_query = "SELECT ui.*, u.name as user_name, i.name as product_name 
                       FROM users_items ui 
                       JOIN users u ON ui.user_id = u.id 
                       JOIN items i ON ui.item_id = i.id 
                       WHERE ui.status != 'Added to cart' 
                       ORDER BY ui.order_date DESC LIMIT 5";
$recent_orders_result = mysqli_query($con, $recent_orders_query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
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
            color: white;
        }
        .panel-primary .panel-heading {
            background: #337ab7 !important;
        }
        .panel-success .panel-heading {
            background: #5cb85c !important;
        }
        .panel-info .panel-heading {
            background: #5bc0de !important;
        }
        .panel-default .panel-heading {
            background: #f8f9fa !important;
        }
        .panel-default .panel-title {
            color: #333;
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
        h2 {
            margin: 0;
            font-size: 36px;
            font-weight: 600;
            color: #333;
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
                <li class="active"><a href="index.php">Dashboard</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="orders.php">Orders</a></li>
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
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Total Users</h3>
                    </div>
                    <div class="panel-body">
                        <h2><?php echo $total_users; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Total Products</h3>
                    </div>
                    <div class="panel-body">
                        <h2><?php echo $total_products; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Total Orders</h3>
                    </div>
                    <div class="panel-body">
                        <h2><?php echo $total_orders; ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Recent Orders</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($order = mysqli_fetch_array($recent_orders_result)) { ?>
                                <tr>
                                    <td><?php echo $order['id']; ?></td>
                                    <td><?php echo $order['user_name']; ?></td>
                                    <td><?php echo $order['product_name']; ?></td>
                                    <td><?php echo $order['status']; ?></td>
                                    <td><?php echo $order['order_date']; ?></td>
                                    <td>
                                        <a href="order_details.php?id=<?php echo $order['id']; ?>" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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