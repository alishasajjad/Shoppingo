<?php
session_start();
require_once '../connection.php';

if(isset($_SESSION['admin_id'])) {
    header('location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            background: url('../img/admin2.jpeg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
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
        .container {
            position: relative;
            z-index: 2;
        }
        .panel {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
            border: none;
            margin-top: 100px;
        }
        .panel-heading {
            background: #337ab7 !important;
            border: none;
            padding: 20px;
        }
        .panel-heading h3 {
            margin: 0;
            color: white;
            text-align: center;
        }
        .panel-body {
            padding: 30px;
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
    </style>
</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Shoppingo Admin</a>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3>Admin Login</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="login_submit.php">
                            <div class="form-group">
                                <input type="text" class="form-control" name="username" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 