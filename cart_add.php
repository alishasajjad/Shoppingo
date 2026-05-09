<?php
    require 'connection.php';
    //require 'header.php';
    session_start();
    $item_id=$_GET['id'];
    $user_id=$_SESSION['id'];
    
    // Check if item is already in cart
    $check_cart_query = "SELECT quantity FROM users_items WHERE user_id='$user_id' AND item_id='$item_id' AND status='Added to cart'";
    $check_cart_result = mysqli_query($con, $check_cart_query);
    
    // Check available stock
    $stock_query = "SELECT stock FROM items WHERE id='$item_id'";
    $stock_result = mysqli_query($con, $stock_query);
    $stock_row = mysqli_fetch_array($stock_result);
    $available_stock = $stock_row['stock'];
    
    if(mysqli_num_rows($check_cart_result) > 0) {
        // Item already in cart, update quantity if stock allows
        $cart_row = mysqli_fetch_array($check_cart_result);
        $current_quantity = $cart_row['quantity'];
        if($current_quantity < $available_stock) {
            $update_query = "UPDATE users_items SET quantity = quantity + 1 WHERE user_id='$user_id' AND item_id='$item_id' AND status='Added to cart'";
            mysqli_query($con, $update_query);
            header('location: products.php?added=1');
        } else {
            header('location: products.php?stock_error=1');
        }
    } else {
        // Item not in cart, add new item if stock available
        if($available_stock > 0) {
            $add_to_cart_query="insert into users_items(user_id,item_id,status) values ('$user_id','$item_id','Added to cart')";
            $add_to_cart_result=mysqli_query($con,$add_to_cart_query) or die(mysqli_error($con));
            header('location: products.php?added=1');
        } else {
            header('location: products.php?stock_error=1');
        }
    }
?>