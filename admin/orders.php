<?php
session_start();
require_once '../connection.php';

if(!isset($_SESSION['admin_id'])) {
    header('location: login.php');
    exit();
}

// Handle order status update
if(isset($_POST['update_status'])) {
    $order_id = mysqli_real_escape_string($con, $_POST['order_id']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $notes = mysqli_real_escape_string($con, $_POST['notes']);
    $admin_id = $_SESSION['admin_id'];

    // Get current order details including previous status for stock management
    $order_query = "SELECT ui.status as current_status, ui.item_id, ui.quantity, u.email, u.name, i.name as product_name 
                   FROM users_items ui 
                   JOIN users u ON ui.user_id = u.id 
                   JOIN items i ON ui.item_id = i.id 
                   WHERE ui.id = '$order_id'";
    $order_result = mysqli_query($con, $order_query);
    $order_details = mysqli_fetch_array($order_result);
    
    $previous_status = $order_details['current_status'];
    $item_id = $order_details['item_id'];
    $quantity = $order_details['quantity'];

    // Update order status
    $query = "UPDATE users_items SET status = '$status' WHERE id = '$order_id'";
    if(mysqli_query($con, $query)) {
        // Handle stock updates based on status changes
        if($previous_status == 'Confirmed' && $status == 'Cancelled') {
            // If order was confirmed but now cancelled, restore stock
            $stock_query = "UPDATE items SET stock = stock + $quantity WHERE id = '$item_id'";
            mysqli_query($con, $stock_query);
        } elseif($previous_status == 'Cancelled' && $status == 'Confirmed') {
            // If order was cancelled but now confirmed, reduce stock
            $stock_query = "UPDATE items SET stock = stock - $quantity WHERE id = '$item_id' AND stock >= $quantity";
            mysqli_query($con, $stock_query);
        }
        
        // Insert into order tracking
        $tracking_query = "INSERT INTO order_tracking (order_id, status, notes, updated_by) 
                          VALUES ('$order_id', '$status', '$notes', '$admin_id')";
        mysqli_query($con, $tracking_query);

        // Send email notification to user
        $to = $order_details['email'];
        $subject = "Order Status Update - Shoppingo";
        $message = "Dear " . $order_details['name'] . ",\n\n";
        $message .= "Your order for " . $order_details['product_name'] . " has been updated.\n";
        $message .= "New Status: " . $status . "\n";
        if($notes) {
            $message .= "Notes: " . $notes . "\n";
        }
        $message .= "\nThank you for shopping with Shoppingo!\n";
        $message .= "best regards,\nShoppingo Team";
        
        $headers = "From: noreply@shopingo.com";
        
        mail($to, $subject, $message, $headers);

        header('location: orders.php?success=1');
        exit();
    } else {
        header('location: orders.php?error=1');
        exit();
    }
}

// Get all orders
$query = "SELECT ui.*, u.name as user_name, u.email as user_email, i.name as product_name, i.price as product_price,
          (i.price * ui.quantity) as total_amount
          FROM users_items ui 
          JOIN users u ON ui.user_id = u.id 
          JOIN items i ON ui.item_id = i.id 
          WHERE ui.status != 'Added to cart' 
          ORDER BY ui.order_date DESC";
$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Orders</title>
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
        .status-form {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .status-form select {
            width: 120px;
        }
        .status-form input[type="text"] {
            width: 200px;
        }
        .alert {
            position: relative;
            z-index: 2;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Shoppingo Admin</a>
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
        <?php if(isset($_GET['success'])) { ?>
        <div class="alert alert-success">Order status has been updated successfully!</div>
        <?php } ?>
        <?php if(isset($_GET['error'])) { ?>
        <div class="alert alert-danger">Error updating order status. Please try again.</div>
        <?php } ?>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Manage Orders</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Order Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($order = mysqli_fetch_array($result)) { ?>
                                <tr>
                                    <td><?php echo $order['id']; ?></td>
                                    <td>
                                        <?php echo $order['user_name']; ?><br>
                                        <small><?php echo $order['user_email']; ?></small>
                                    </td>
                                    <td><?php echo $order['product_name']; ?></td>
                                    <td><?php echo $order['quantity']; ?></td>
                                    <td>Rs. <?php echo number_format($order['total_amount'], 2); ?></td>
                                    <td>
                                        <form method="post" action="" class="status-form">
                                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                            <select name="status" class="form-control input-sm">
                                                <option value="Confirmed" <?php echo $order['status'] == 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                                <option value="Processing" <?php echo $order['status'] == 'Processing' ? 'selected' : ''; ?>>Processing</option>
                                                <option value="Shipped" <?php echo $order['status'] == 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                                                <option value="Delivered" <?php echo $order['status'] == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                                <option value="Cancelled" <?php echo $order['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                            </select>
                                            <input type="text" name="notes" class="form-control input-sm" placeholder="Notes">
                                            <button type="submit" name="update_status" class="btn btn-primary btn-sm">Update</button>
                                        </form>
                                    </td>
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