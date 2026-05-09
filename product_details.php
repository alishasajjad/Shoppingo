<?php
require 'connection.php';
session_start();
require_once 'check_if_added.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('location: products.php');
    exit();
}

$product_id = intval($_GET['id']);
$query = "SELECT * FROM items WHERE id = '$product_id'";
$result = mysqli_query($con, $query);
$product = mysqli_fetch_array($result);

if (!$product) {
    header('location: products.php');
    exit();
}

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
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($product['name']); ?> - Shoppingo</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background: url('img/intro-bg_1.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            padding-bottom: 80px;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }
        .main-content {
            position: relative;
            z-index: 2;
            margin-top: 100px;
            margin-bottom: 60px;
        }
        .product-card {
            background: rgba(255,255,255,0.98);
            box-shadow: 0 2px 12px rgba(0,0,0,0.18);
            border-radius: 10px;
            padding: 30px 20px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }
        .product-image-col {
            text-align: center;
            margin-bottom: 20px;
        }
        .product-image {
            width: 100%;
            max-width: 320px;
            height: 320px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        }
        .product-details-col {
            padding-left: 30px;
        }
        .product-title {
            font-size: 2em;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }
        .product-price {
            font-size: 1.5em;
            color: #337ab7;
            margin-bottom: 10px;
        }
        .product-desc {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 18px;
        }
        .product-stock {
            font-size: 1em;
            color: #28a745;
            margin-bottom: 18px;
        }
        .btn-add {
            font-size: 16px;
            padding: 10px 30px;
            margin-bottom: 10px;
        }
        @media (max-width: 991px) {
            .product-card {
                flex-direction: column;
                padding: 20px 10px;
            }
            .product-details-col {
                padding-left: 0;
            }
            .product-image {
                max-width: 100%;
                height: 220px;
            }
            .main-content {
                margin-top: 60px;
            }
        }
    </style>
</head>
<body>
    <?php require 'includes/header.php'; ?>
    <div class="container main-content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="product-card">
                    <div class="col-sm-5 product-image-col">
                        <img src="<?php echo $image_path; ?>" class="product-image" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    </div>
                    <div class="col-sm-7 product-details-col">
                        <div class="product-title"><?php echo htmlspecialchars($product['name']); ?></div>
                        <div class="product-price">Rs. <?php echo number_format($product['price'], 2); ?></div>
                        <div class="product-desc"><?php echo nl2br(htmlspecialchars($product['description'])); ?></div>
                        <div class="product-stock">
                            <?php if ($product['stock'] > 0) {
                                echo 'In Stock: <b>' . $product['stock'] . '</b>';
                            } else {
                                echo '<span style="color:#d32f2f">Out of Stock</span>';
                            } ?>
                        </div>
                        <?php
                        if (!isset($_SESSION['id'])) {
                            echo '<a href="login.php" class="btn btn-primary btn-add">Login to Add to Cart</a>';
                        } else if ($product['stock'] > 0) {
                            if (check_if_added_to_cart($product['id'])) {
                                echo '<a href="#" class="btn btn-success btn-add disabled">Added to Cart</a>';
                            } else {
                                echo '<a href="cart_add.php?id=' . $product['id'] . '" class="btn btn-primary btn-add">Add to Cart</a>';
                            }
                        }
                        ?>
                        <div style="margin-top:20px;">
                            <a href="products.php" class="btn btn-default">Back to Products</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
    <script src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html> 