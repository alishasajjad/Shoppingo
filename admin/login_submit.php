<?php
session_start();
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = md5($_POST['password']); // Using MD5 for password hashing

    $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $_SESSION['admin_id'] = $row['id'];
        $_SESSION['admin_username'] = $row['username'];
        header('location: index.php');
    } else {
        header('location: login.php?error=1');
    }
} else {
    header('location: login.php');
}
?> 