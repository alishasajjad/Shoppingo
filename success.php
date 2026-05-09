<?php
    session_start();
    require_once 'connection.php';

    if(!isset($_SESSION['id'])) {
        header('location: login.php');
        exit();
    }

    if(!isset($_GET['order_id'])) {
        header('location: cart.php');
        exit();
    }

    $order_id = mysqli_real_escape_string($con, $_GET['order_id']);
    $user_id = $_SESSION['id'];

    // Get order details
    $query = "SELECT ui.*, i.name as product_name, i.price as product_price, i.image,
              (i.price * ui.quantity) as total_amount
              FROM users_items ui 
              JOIN items i ON ui.item_id = i.id 
              WHERE ui.id = '$order_id' AND ui.user_id = '$user_id' AND ui.status = 'Confirmed'";
    $result = mysqli_query($con, $query);
    $order = mysqli_fetch_array($result);

    if(!$order) {
        header('location: cart.php');
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="img/lifestyleStore.png" />
        <title>Order Confirmation - Shoppingo</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- latest compiled and minified CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
        <!-- jquery library -->
        <script type="text/javascript" src="bootstrap/js/jquery-3.2.1.min.js"></script>
        <!-- Latest compiled and minified javascript -->
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <!-- External CSS -->
        <link rel="stylesheet" href="css/style.css" type="text/css">
        <style>
            body {
                background: url('img/intro-bg_1.jpg') no-repeat center center fixed;
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
                text-align: center;
            }
            .panel-title {
                font-size: 18px;
                font-weight: 600;
                color: #333;
            }
            .panel-primary .panel-heading {
                background: #337ab7 !important;
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
            .success-message {
                font-size: 18px;
                margin-bottom: 20px;
            }
            .btn-primary {
                display: inline-block;
                padding: 10px 20px;
                background: #337ab7;
                color: white;
                text-decoration: none;
                border-radius: 4px;
                transition: background 0.3s;
            }
            .btn-primary:hover {
                background: #286090;
                color: white;
                text-decoration: none;
            }
            .success-icon {
                color: #28a745;
                font-size: 48px;
                margin-bottom: 20px;
            }
            .order-details {
                margin-top: 30px;
            }
            .order-details h4 {
                color: #333;
                margin-bottom: 15px;
            }
            .order-details p {
                margin-bottom: 5px;
            }
            .order-details strong {
                color: #555;
            }
        </style>
    </head>
    <body>
        <div>
            <?php
                require 'includes/header.php';
            ?>
            <br>
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Order Confirmation</h3>
                            </div>
                            <div class="panel-body text-center">
                                <div class="success-icon">
                                    <i class="glyphicon glyphicon-ok-circle"></i>
                                </div>
                                <h2>Thank You for Your Order!</h2>
                                <p>Your order has been successfully placed.</p>
                                
                                <div class="order-details">
                                    <h4>Order Details</h4>
                                    <p><strong>Order ID:</strong> #<?php echo $order['id']; ?></p>
                                    <p><strong>Product:</strong> <?php echo $order['product_name']; ?></p>
                                    <p><strong>Quantity:</strong> <?php echo $order['quantity']; ?></p>
                                    <p><strong>Total Amount:</strong> Rs. <?php echo number_format($order['total_amount'], 2); ?></p>
                                    <p><strong>Order Date:</strong> <?php echo $order['order_date']; ?></p>
                                </div>

                                <div class="text-center" style="margin-top: 30px;">
                                    <a href="my_orders.php" class="btn btn-primary">View My Orders</a>
                                    <a href="products.php" class="btn btn-default">Continue Shopping</a>
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
        </div>
    </body>
</html>
