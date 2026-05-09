<?php
    session_start();
    require 'check_if_added.php';
    require 'connection.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="img/lifestyleStore.png" />
        <title>Shoppingo - Products</title>
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
        </style>
    </head>
    <body>
        <div>
            <?php
                require 'includes/header.php';
            ?>
            <div class="container">
                <div class="jumbotron">
                    <h1>Welcome to Shoppingo!</h1>
                    <p>We have the best cameras, watches and shirts for you. No need to hunt around, we have all in one place.</p>
                </div>
                <?php if(isset($_GET['added'])) { ?>
                <div class="alert alert-success">
                    <strong>Success!</strong> Item has been added to your cart successfully.
                </div>
                <?php } ?>
                <?php if(isset($_GET['stock_error'])) { ?>
                <div class="alert alert-danger">
                    <strong>Error!</strong> Sorry, this item is out of stock or you have reached the maximum available quantity.
                </div>
                <?php } ?>
            </div>
            <div class="container">
                                        <?php
                // Fetch all products from the database
                $query = "SELECT * FROM items ORDER BY id ASC";
                $result = mysqli_query($con, $query);
                
                // Counter for row breaks
                $counter = 0;
                
                while($product = mysqli_fetch_array($result)) {
                    // Start new row after every 4 products
                    if($counter % 4 == 0) {
                        if($counter > 0) {
                            echo '</div>'; // Close previous row
                        }
                        echo '<div class="row">';
                    }

                    // Get image path
                    $image_path = '';
                    if ($product['image']) {
                        if (strpos($product['image'], 'products/') === 0) {
                            $image_path = 'img/' . $product['image'];
                        } else {
                            $image_path = 'img/products/' . $product['image'];
                        }
                    } else {
                        $image_path = 'img/default.jpg';
                    }
                    ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="thumbnail">
                            <a href="product_details.php?id=<?php echo $product['id']; ?>">
                                <img src="<?php echo $image_path; ?>" alt="<?php echo $product['name']; ?>">
                            </a>
                            <center>
                                <div class="caption">
                                    <h3><?php echo $product['name']; ?></h3>
                                    <p>Price: Rs. <?php echo number_format($product['price'], 2); ?></p>
                                    <?php if(!isset($_SESSION['email'])){  ?>
                                        <p><a href="login.php" role="button" class="btn btn-primary btn-block">Buy Now</a></p>
                                        <?php
                                        }
                                        else{
                                            if(check_if_added_to_cart($product['id'])){
                                                echo '<a href="#" class=btn btn-block btn-success disabled>Added to cart</a>';
                                            }else{
                                                ?>
                                                <a href="cart_add.php?id=<?php echo $product['id']; ?>" class="btn btn-block btn-primary" name="add" value="add" class="btn btn-block btr-primary">Add to cart</a>
                                                <?php
                                            }
                                        }
                                        ?>
                                </div>
                            </center>
                        </div>
                    </div>
                                        <?php
                    $counter++;
                }
                
                // Close the last row if there are any products
                if($counter > 0) {
                    echo '</div>';
                }
                                                ?>
            </div>
            <br><br><br><br><br><br><br><br>
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
