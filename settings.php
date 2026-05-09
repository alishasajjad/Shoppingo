<?php
    session_start();
    require 'connection.php';
    if(!isset($_SESSION['email'])){
        header('location:index.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="img/lifestyleStore.png" />
        <title>Shoppingo - Settings</title>
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
            .form-control {
                height: 45px;
                font-size: 16px;
                margin-bottom: 15px;
                background: rgba(255, 255, 255, 0.9);
            }
            .btn-primary {
                height: 45px;
                font-size: 16px;
                background: #337ab7;
                border: none;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            .btn-primary:hover {
                background: #286090;
                box-shadow: 0 2px 8px rgba(0,0,0,0.2);
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
            .alert {
                background: rgba(255, 255, 255, 0.95);
                box-shadow: 0 2px 8px rgba(0,0,0,0.2);
                border: none;
            }
            .form-group label {
                color: #333;
                font-weight: 500;
            }
            h1 {
                color: white;
                text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
                margin-bottom: 30px;
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
                    <div class="col-xs-4 col-xs-offset-4">
                        <h1>Change Password</h1>
                        <form method="post" action="setting_script.php">
                            <div class="form-group">
                                <input type="password" class="form-control" name="oldPassword" placeholder="Old Password">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="newPassword" placeholder="New Password">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="retype" placeholder="Re-type new password">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Change">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <br><br><br><br><br>
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
