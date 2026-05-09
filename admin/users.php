<?php
session_start();
require_once '../connection.php';

if(!isset($_SESSION['admin_id'])) {
    header('location: login.php');
    exit();
}

// Handle user deletion
if(isset($_GET['delete'])) {
    $user_id = mysqli_real_escape_string($con, $_GET['delete']);
    
    // Start transaction
    mysqli_begin_transaction($con);
    
    try {
        // Delete user's cart items and orders
        $query = "DELETE FROM users_items WHERE user_id = '$user_id'";
        mysqli_query($con, $query);
        
        // Delete user's order tracking records
        $query = "DELETE ot FROM order_tracking ot 
                 INNER JOIN users_items ui ON ot.order_id = ui.id 
                 WHERE ui.user_id = '$user_id'";
        mysqli_query($con, $query);
        
        // Finally delete the user
        $query = "DELETE FROM users WHERE id = '$user_id'";
        mysqli_query($con, $query);
        
        // If everything is successful, commit the transaction
        mysqli_commit($con);
        header('location: users.php?success=1');
    } catch (Exception $e) {
        // If there's an error, rollback the transaction
        mysqli_rollback($con);
        header('location: users.php?error=1');
    }
    exit();
}

// Get all users
$query = "SELECT u.*, 
          (SELECT COUNT(*) FROM users_items WHERE user_id = u.id AND status != 'Added to cart') as total_orders,
          (SELECT SUM(i.price * ui.quantity) 
           FROM users_items ui 
           INNER JOIN items i ON ui.item_id = i.id 
           WHERE ui.user_id = u.id AND ui.status != 'Added to cart') as total_spent
          FROM users u 
          ORDER BY u.id DESC";
$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Users</title>
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
                <a class="navbar-brand" href="index.php">Shoppingo Admin</a>
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
        <?php if(isset($_GET['success'])) { ?>
        <div class="alert alert-success">User has been deleted successfully!</div>
        <?php } ?>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Manage Users</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>City</th>
                                    <th>Total Orders</th>
                                    <th>Total Spent</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($user = mysqli_fetch_array($result)) { ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo $user['name']; ?></td>
                                    <td><?php echo $user['email']; ?></td>
                                    <td><?php echo $user['contact']; ?></td>
                                    <td><?php echo $user['city']; ?></td>
                                    <td><?php echo $user['total_orders']; ?></td>
                                    <td>Rs. <?php echo number_format($user['total_spent'], 2); ?></td>
                                    <td>
                                        <a href="user_details.php?id=<?php echo $user['id']; ?>" class="btn btn-info btn-sm">View Details</a>
                                        <a href="users.php?delete=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
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