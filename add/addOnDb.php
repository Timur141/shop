<?php

error_reporting(E_ALL);

require($_SERVER['DOCUMENT_ROOT'] . '/functions/connect.php');
require($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php');

$postData = $_POST;

$catSetString = '';
$id = mysqli_real_escape_string($conn, $postData["id"]);
$name = mysqli_real_escape_string($conn, $postData['product-name']);
$price = $postData['product-price'] ? (int)$postData['product-price'] : 1;
$sale = ($postData['sale'] == 'on') ? 1 : 0;
$new = ($postData['new'] == 'on') ? 1 : 0;
$imgBaseString = mysqli_real_escape_string($conn, $postData['imgBaseString']);

if ($imgBaseString != 'none' && mb_stristr($imgBaseString, 'data:image/jpeg;base64')) {
    $imgBaseString = $postData['imgBaseString'];
    $imgPath = baseToJpeg($imgBaseString);
    $imgPathArray = explode('/', $imgPath);
    $img = '/img/' . $imgPathArray[count($imgPathArray) - 2] . '/' . $imgPathArray[count($imgPathArray) - 1];
} elseif ($imgBaseString == 'none') {
    $img = '/img/products/disable.jpg';
} else {
    $img = $imgBaseString;
}

if ($id != 0) {

    $sqlDelete = "select
                    img
                from
                    products
                where
                    id = '$id'";

    $resultDelete = mysqli_query($conn, $sqlDelete);

    if (mysqli_num_rows($resultDelete) > 0) {
        while($row = mysqli_fetch_assoc($resultDelete)) {
            $imgToDelete = $row['img'];
        }
    }

    if ($imgToDelete != '/img/products/disable.jpg') {

        unlink($_SERVER['DOCUMENT_ROOT'] . $imgToDelete);
    }

    $sqlUpdate = "update
                    products
                set
                    name = '$name', price = '$price', is_sale = '$sale', is_new = '$new', img = '$img'
                where
                    id = '$id'";

    $result = mysqli_query($conn, $sqlUpdate);
} else {
    $sqlInsert = "insert into
                    products
                        (id, name, price, img, is_sale, is_new)
                    values
                        (NULL, '$name', $price, '$img', $sale, $new)
                ";
    $result = mysqli_query($conn, $sqlInsert);

    $id = mysqli_insert_id($conn);
}

if (isset($postData['category'])) {

    foreach ($postData['category'] as $catNumber) {
        $catSetString .= ' (' . $id . ', ' . $catNumber . '),';
    }

    $catSetString = substr($catSetString, 0, -1);

}

$sqlDeleteCats = "delete from
                    categories_products
                where
                    product_id = '$id'
                ";
$result = mysqli_query($conn, $sqlDeleteCats);

$sqlInsertCats = "insert into
                    categories_products
                    (product_id, categorie_id)
                values
                    $catSetString
                ";
                 
$result = mysqli_query($conn, $sqlInsertCats);

if ($result) {
    $respond['result'] = 'success';
    $respond['text'] = '';
} else {
    $respond['result'] = 'error';
    $respond['text'] = 'Ошибка, попробуйте еще раз.';
}

echo json_encode($respond);

mysqli_close($conn);
