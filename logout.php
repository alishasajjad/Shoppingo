<?php
    session_start();
    session_unset();
    session_destroy();
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="img/lifestyleStore.png" />
        <title>Shoppingo - Logout</title>
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
            .logout-message {
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
                    <div class="col-xs-8 col-xs-offset-2">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Logout</h3>
                            </div>
                            <div class="panel-body">
                                <p class="logout-message">You have been logged out. Thank you for shopping with us!</p>
                                <a href="login.php" class="btn btn-primary">Login Again</a>
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
