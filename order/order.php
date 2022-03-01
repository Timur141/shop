<?php

error_reporting(E_ALL);

require($_SERVER['DOCUMENT_ROOT'] . '/functions/connect.php');
require($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php');

$orderData = $_POST;

if ($orderData['comment'] != '') {
    $comment = $orderData['comment'];
} else {
     $comment = 0;
}

if ($orderData['id'] != '') {
    $product_id = $orderData['id'];
} else {
    $product_id = 0;
}

$pay = ($orderData['pay']);
$isProcessed = 0;

$priceQuery = "select
                    price
                from 
                    products
                where
                    id = '$product_id'";

$price = mysqli_query($conn, $priceQuery);
$price = mysqli_fetch_assoc($price);
$price = (int)$price['price'];


if ($orderData['delivery'] == 'dev-no') {
    $delivery = 0;
    if (issetUserData($orderData)) {

        $name = $orderData['name'];
        $surname = $orderData['surname'];
        $phone = $orderData['phone'];
        $email = $orderData['email'];

        $sql = "insert into
                    orders (name, surname, phone, email, delivery, pay, comment, product_id, is_processed, price)
                values
                    ('$name', '$surname', '$phone', '$email', '$delivery', '$pay', '$comment', '$product_id', '$isProcessed', '$price')";
        $result = mysqli_query($conn, $sql);
    }

} elseif ($orderData['delivery'] == 'dev-yes') {

    $delivery = 1;
    if (issetOrderData($orderData) and issetUserData($orderData)) {

        $name = $orderData['name'];
        $surname = $orderData['surname'];
        $phone = $orderData['phone'];
        $email = $orderData['email'];
        $city = $orderData['city'];
        $home = $orderData['home'];
        $street = $orderData['street'];
        $aprt = $orderData['aprt'];
        $isProcessed = 0;
        $price = $price + 280;

        $sql = "insert into orders
                    (name, surname, phone, email, delivery, pay, comment, product_id, city, home, street, apt, is_processed, price)
                values
                    ('$name', '$surname', '$phone', '$email', '$delivery', '$pay', '$comment', '$product_id', '$city', '$home',
                    '$street', '$aprt', $isProcessed, '$price')";
        $result = mysqli_query($conn, $sql);
    }
}

if ($result) {
    $respond['result'] = 'success';
    $respond['text'] = '';
} else {
    $respond['result'] = 'error';
    $respond['text'] = 'Ошибка, попробуйте еще раз.';
}

echo json_encode($respond);

mysqli_close($conn);
