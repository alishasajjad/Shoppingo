<?php
session_start();
require_once '../connection.php';

if(!isset($_SESSION['admin_id'])) {
    header('location: login.php');
    exit();
}

// Get admin details
$admin_id = $_SESSION['admin_id'];
$query = "SELECT * FROM admin WHERE id = '$admin_id'";
$result = mysqli_query($con, $query);
$admin = mysqli_fetch_array($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $current_password = md5($_POST['current_password']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify current password
    if($current_password != $admin['password']) {
        $error = "Current password is incorrect";
    }
    // Check if new password is provided
    else if(!empty($new_password)) {
        if($new_password != $confirm_password) {
            $error = "New passwords do not match";
        } else {
            $new_password = md5($new_password);
            $query = "UPDATE admin SET username = '$username', email = '$email', password = '$new_password' WHERE id = '$admin_id'";
            mysqli_query($con, $query);
            $success = "Settings updated successfully";
        }
    } else {
        $query = "UPDATE admin SET username = '$username', email = '$email' WHERE id = '$admin_id'";
        mysqli_query($con, $query);
        $success = "Settings updated successfully";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Settings</title>
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
        .form-control {
            height: 45px;
            font-size: 16px;
            margin-bottom: 15px;
        }
        .btn-primary {
            height: 45px;
            font-size: 16px;
            background: #337ab7;
            border: none;
        }
        .btn-primary:hover {
            background: #286090;
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
                <li><a href="users.php">Users</a></li>
                <li class="active"><a href="settings.php">Settings</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Admin Settings</h3>
                    </div>
                    <div class="panel-body">
                        <?php if(isset($error)) { ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php } ?>
                        <?php if(isset($success)) { ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php } ?>

                        <form method="post" action="">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" value="<?php echo $admin['username']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="<?php echo $admin['email']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Current Password</label>
                                <input type="password" class="form-control" name="current_password" required>
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" class="form-control" name="new_password">
                                <small class="text-muted">Leave blank if you don't want to change the password</small>
                            </div>
                            <div class="form-group">
                                <label>Confirm New Password</label>
                                <input type="password" class="form-control" name="confirm_password">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Settings</button>
                        </form>
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