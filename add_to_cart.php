<?php
session_start();
include'../../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id    = $_POST['product_id'];
    $name  = $_POST['product_name'];
    $price = $_POST['product_price'];
    $image = $_POST['product_image'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$id] = array(
            'name'     => $name,
            'price'    => $price,
            'image'    => $image,
            'quantity' => 1
        );
    }

    header("Location: cart.php");
    exit();
}
?>