<?php
session_start();
require_once '../connection.php';

if(!isset($_SESSION['admin_id'])) {
    header('location: login.php');
    exit();
}

if(!isset($_GET['id'])) {
    header('location: products.php');
    exit();
}

$id = mysqli_real_escape_string($con, $_GET['id']);
$query = "SELECT * FROM items WHERE id = '$id'";
$result = mysqli_query($con, $query);
$product = mysqli_fetch_array($result);

if(!$product) {
    header('location: products.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $stock = mysqli_real_escape_string($con, $_POST['stock']);
    
    // Handle image upload
    $image = $product['image'];
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../img/products/";
        if(!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $image = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        
        // Delete old image if exists
        if($product['image'] && file_exists($target_dir . $product['image'])) {
            unlink($target_dir . $product['image']);
        }
    }

    $query = "UPDATE items SET name = '$name', price = '$price', description = '$description', image = '$image', stock = '$stock' WHERE id = '$id'";
    mysqli_query($con, $query);
    header('location: products.php?success=1');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Edit Product</title>
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
                <li class="active"><a href="products.php">Products</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="settings.php">Settings</a></li>
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
                        <h3 class="panel-title">Edit Product</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Product Name</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $product['name']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Price (Rs.)</label>
                                <input type="number" class="form-control" name="price" value="<?php echo $product['price']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description" rows="3"><?php echo $product['description']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" class="form-control" name="stock" value="<?php echo $product['stock']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Current Image</label>
                                <?php if($product['image']) { ?>
                                <img src="../img/products/<?php echo $product['image']; ?>" class="img-thumbnail" style="max-width: 200px;">
                                <?php } else { ?>
                                <p>No image uploaded</p>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label>Change Image</label>
                                <input type="file" class="form-control" name="image">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Product</button>
                            <a href="products.php" class="btn btn-default">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php include 'footer.php'; ?>
</body>
</html> 