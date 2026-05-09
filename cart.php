<?php
    session_start();
    require_once 'connection.php';
    if(!isset($_SESSION['id'])){
        header('location: login.php');
        exit();
    }
    $user_id=$_SESSION['id'];

    // Handle order confirmation
    if(isset($_POST['confirm_order'])) {
        $item_id = mysqli_real_escape_string($con, $_POST['item_id']);
        
        // First, get the users_items ID
        $get_id_query = "SELECT id FROM users_items 
                        WHERE user_id = '$user_id' AND item_id = '$item_id' AND status = 'Added to cart'";
        $id_result = mysqli_query($con, $get_id_query);
        $row = mysqli_fetch_array($id_result);
        $users_items_id = $row['id'];
        
        if($users_items_id) {
            // Get order details to update stock
            $order_details_query = "SELECT item_id, quantity FROM users_items WHERE id = '$users_items_id'";
            $order_details_result = mysqli_query($con, $order_details_query);
            $order_details = mysqli_fetch_array($order_details_result);
            
            // Update status to Confirmed and set order date
            $query = "UPDATE users_items SET status = 'Confirmed', order_date = NOW() 
                      WHERE id = '$users_items_id'";
            
            if(mysqli_query($con, $query)) {
                // Update stock - decrease by ordered quantity
                $update_stock_query = "UPDATE items SET stock = stock - " . $order_details['quantity'] . " 
                                      WHERE id = '" . $order_details['item_id'] . "' AND stock >= " . $order_details['quantity'];
                mysqli_query($con, $update_stock_query);
                
                // Get the default admin ID (assuming ID 1 is the default admin)
                $admin_query = "SELECT id FROM admin LIMIT 1";
                $admin_result = mysqli_query($con, $admin_query);
                $admin_row = mysqli_fetch_array($admin_result);
                $admin_id = $admin_row['id'];

                // Insert into order tracking using the correct users_items ID and admin ID
                $tracking_query = "INSERT INTO order_tracking (order_id, status, notes, updated_by) 
                                  VALUES ('$users_items_id', 'Confirmed', 'Order confirmed by customer', '$admin_id')";
                mysqli_query($con, $tracking_query);
                
                // Redirect to success page with order ID
                header('location: success.php?order_id=' . $users_items_id);
                exit();
            }
        }
    }

    // Handle item removal
    if(isset($_GET['remove'])) {
        $item_id = mysqli_real_escape_string($con, $_GET['remove']);
        $query = "DELETE FROM users_items WHERE user_id = '$user_id' AND item_id = '$item_id' AND status = 'Added to cart'";
        mysqli_query($con, $query);
        header('location: cart.php');
        exit();
    }

    // Handle quantity update
    if(isset($_POST['update_quantity'])) {
        $item_id = mysqli_real_escape_string($con, $_POST['item_id']);
        $new_quantity = max(1, intval($_POST['quantity']));
        
        // Check available stock
        $stock_query = "SELECT stock FROM items WHERE id = '$item_id'";
        $stock_result = mysqli_query($con, $stock_query);
        $stock_row = mysqli_fetch_array($stock_result);
        $available_stock = $stock_row['stock'];
        
        if($new_quantity <= $available_stock) {
            $query = "UPDATE users_items SET quantity = '$new_quantity' WHERE user_id = '$user_id' AND item_id = '$item_id' AND status = 'Added to cart'";
            mysqli_query($con, $query);
            header('location: cart.php?updated=1');
        } else {
            header('location: cart.php?stock_error=1');
        }
        exit();
    }

    // Get cart items
    $query = "SELECT ui.*, i.name, i.price, i.image 
              FROM users_items ui 
              JOIN items i ON ui.item_id = i.id 
              WHERE ui.user_id = '$user_id' AND ui.status = 'Added to cart'";
    $result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="img/lifestyleStore.png" />
        <title>Shoppingo - Cart</title>
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
            .jumbotron {
                background: rgba(255, 255, 255, 0.95);
                box-shadow: 0 2px 8px rgba(0,0,0,0.2);
                position: relative;
                z-index: 2;
            }
            .thumbnail {
                background: white;
                box-shadow: 0 2px 8px rgba(0,0,0,0.2);
                transition: transform 0.2s;
            }
            .thumbnail:hover {
                transform: translateY(-2px);
            }
            .table-responsive {
                background: rgba(255, 255, 255, 0.95);
                box-shadow: 0 2px 8px rgba(0,0,0,0.2);
                border-radius: 4px;
                padding: 15px;
            }
            .table > tbody > tr > td {
                vertical-align: middle;
            }
            .btn-primary {
                background: #337ab7;
                border: none;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            .btn-primary:hover {
                background: #286090;
                box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            }
            .cart-item {
                display: flex;
                align-items: center;
                margin-bottom: 20px;
                padding-bottom: 20px;
                border-bottom: 1px solid #eee;
            }
            .cart-item:last-child {
                border-bottom: none;
                margin-bottom: 0;
                padding-bottom: 0;
            }
            .cart-image {
                width: 100px;
                height: 100px;
                object-fit: cover;
                margin-right: 20px;
                border-radius: 4px;
            }
            .cart-details {
                flex: 1;
            }
            .cart-actions {
                display: flex;
                gap: 10px;
            }
            .btn-remove {
                background: #dc3545;
                color: white;
            }
            .btn-remove:hover {
                background: #c82333;
                color: white;
            }
            .btn-confirm {
                background: #28a745;
                color: white;
            }
            .btn-confirm:hover {
                background: #218838;
                color: white;
            }
            .empty-cart {
                text-align: center;
                padding: 40px 0;
            }
            .empty-cart h3 {
                margin-bottom: 20px;
                color: #666;
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
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Shopping Cart</h3>
                            </div>
                            <div class="panel-body">
                                <?php if(isset($_GET['updated'])) { ?>
                                <div class="alert alert-success">
                                    <strong>Success!</strong> Cart quantity has been updated successfully.
                                </div>
                                <?php } ?>
                                <?php if(isset($_GET['stock_error'])) { ?>
                                <div class="alert alert-danger">
                                    <strong>Error!</strong> Sorry, the requested quantity exceeds available stock.
                                </div>
                                <?php } ?>
                                <?php if(mysqli_num_rows($result) > 0) { ?>
                                    <?php 
                                    $total = 0;
                                    while($item = mysqli_fetch_array($result)) { 
                                        $total += $item['price'] * $item['quantity'];
                                    ?>
                                        <div class="cart-item">
                                            <?php
                                            // Get image path
                                            $image_path = '';
                                            if ($item['image']) {
                                                if (strpos($item['image'], 'products/') === 0) {
                                                    $image_path = 'img/' . $item['image'];
                                                } else {
                                                    $image_path = 'img/products/' . $item['image'];
                                                }
                                            } else {
                                                $image_path = 'img/default.jpg';
                                            }
                                            ?>
                                            <img src="<?php echo $image_path; ?>" class="cart-image" alt="<?php echo $item['name']; ?>">
                                            <div class="cart-details">
                                                <h4><?php echo $item['name']; ?></h4>
                                                <p>Price: Rs. <?php echo number_format($item['price'], 2); ?></p>
                                                <p>Quantity: <?php echo $item['quantity']; ?></p>
                                                <p>Subtotal: Rs. <?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
                                            </div>
                                            <div class="cart-actions">
                                                <form method="post" action="" style="display:inline-block; margin-bottom:0;">
                                                    <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" style="width:60px; display:inline-block;">
                                                    <button type="submit" name="update_quantity" class="btn btn-xs btn-info">Update</button>
                                                </form>
                                                <form method="post" action="" style="display: inline;">
                                                    <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                                                    <button type="submit" name="confirm_order" class="btn btn-confirm">Confirm Order</button>
                                                </form>
                                                <a href="cart.php?remove=<?php echo $item['item_id']; ?>" class="btn btn-remove" 
                                                   onclick="return confirm('Are you sure you want to remove this item?')">Remove</a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="text-right">
                                        <h4>Total Amount: Rs. <?php echo number_format($total, 2); ?></h4>
                                    </div>
                                <?php } else { ?>
                                    <div class="empty-cart">
                                        <h3>Your cart is empty</h3>
                                        <a href="products.php" class="btn btn-primary">Continue Shopping</a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br><br><br><br><br><br><br><br><br><br>
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
