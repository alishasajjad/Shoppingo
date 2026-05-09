<?php
session_start();
require_once 'connection.php';

if(!isset($_SESSION['id'])) {
    header('location: login.php');
    exit();
}

$user_id = $_SESSION['id'];

// Get all orders for the user
$query = "SELECT ui.*, i.name as product_name, i.price as product_price, i.image,
          (i.price * ui.quantity) as total_amount
          FROM users_items ui 
          JOIN items i ON ui.item_id = i.id 
          WHERE ui.user_id = '$user_id' AND ui.status != 'Added to cart'
          ORDER BY ui.order_date DESC";
$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Orders - Shoppingo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
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
        .order-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .order-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .order-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-right: 20px;
            border-radius: 4px;
        }
        .order-details {
            flex: 1;
        }
        .order-status {
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-confirmed { background: #e3f2fd; color: #1976d2; }
        .status-processing { background: #fff3e0; color: #f57c00; }
        .status-shipped { background: #e8f5e9; color: #388e3c; }
        .status-delivered { background: #f1f8e9; color: #689f38; }
        .status-cancelled { background: #ffebee; color: #d32f2f; }
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
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">My Orders</h3>
                    </div>
                    <div class="panel-body">
                        <?php if(mysqli_num_rows($result) > 0) { ?>
                            <?php while($order = mysqli_fetch_array($result)) { ?>
                                <div class="order-item">
                                    <?php
                                    // Get image path
                                    $image_path = '';
                                    if ($order['image']) {
                                        if (strpos($order['image'], 'products/') === 0) {
                                            $image_path = 'img/' . $order['image'];
                                        } else {
                                            $image_path = 'img/products/' . $order['image'];
                                        }
                                    } else {
                                        $image_path = 'img/default.jpg';
                                    }
                                    ?>
                                    <img src="<?php echo $image_path; ?>" class="order-image" alt="<?php echo $order['product_name']; ?>">
                                    <div class="order-details">
                                        <h4><?php echo $order['product_name']; ?></h4>
                                        <p>Quantity: <?php echo $order['quantity']; ?></p>
                                        <p>Total Amount: Rs. <?php echo number_format($order['total_amount'], 2); ?></p>
                                        <p>Order Date: <?php echo $order['order_date']; ?></p>
                                        <span class="order-status status-<?php echo strtolower($order['status']); ?>">
                                            <?php echo $order['status']; ?>
                                        </span>
                                        
                                        <?php
                                        // Get order tracking history
                                        $tracking_query = "SELECT * FROM order_tracking WHERE order_id = '{$order['id']}' ORDER BY created_at DESC";
                                        $tracking_result = mysqli_query($con, $tracking_query);
                                        if(mysqli_num_rows($tracking_result) > 0) {
                                        ?>
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
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="text-center">
                                <h4>You haven't placed any orders yet.</h4>
                                <a href="products.php" class="btn btn-primary">Start Shopping</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html> 