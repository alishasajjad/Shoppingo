<?php
    require 'connection.php';
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="img/lifestyleStore.png" />
        <title>Shoppingo - Login</title>
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
                min-height: 100vh;
            }
            body::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
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
        <div>
            <?php
                require 'includes/header.php';
            ?>
            <br><br><br>
           <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3>LOGIN</h3>
                            </div>
                            <div class="panel-body">
                                <p>Login to make a purchase.</p>
                                <form method="post" action="login_submit.php">
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email" placeholder="Email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" placeholder="Password(min. 6 characters)" pattern=".{6,}">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="Login" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                            <div class="panel-footer">Don't have an account yet? <a href="signup.php">Register</a></div>
                        </div>
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
