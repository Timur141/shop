<?php

error_reporting(E_ALL);

require($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php');
require($_SERVER['DOCUMENT_ROOT'] . '/functions/connect.php');


$id = mysqli_real_escape_string($conn, $_POST["id"]);
if (isset($_POST["hash"])) {
    $hash = $_POST["hash"];
} else {
    $hash = 0;
}

if ($id == 0) {
    $row = ['name' => '', 'price' => '', 'img' => '', 'cat_id' => '', 'is_new' => '', 'is_sale' => ''];
    $categories = [];
} else {
    $sql = "select distinct
                p.*, c.id as cat_id from products as p
            left join
                categories_products as cp on p.id = cp.product_id
            left join
                categories as c on cp.categorie_id = c.id
            where
                p.id = '$id'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result)) {
        $row = mysqli_fetch_assoc($result);
    }

    $sqlCategories = "select
                        p.id as prod_id, c.id as cat_id
                    from
                        products as p
                    left join
                        categories_products as cp on p.id = cp.product_id
                    left join
                        categories as c on cp.categorie_id = c.id
                    where p.id = '$id'";

    $resultCategories = mysqli_query($conn, $sqlCategories);

    if (mysqli_num_rows($resultCategories) > 0) {

        $categories = [];
        while($rowCategories = mysqli_fetch_assoc($resultCategories)) {

            $categories[] = $rowCategories;

        }

    } else {

        echo 'Ошибка запроса к БД';

    }
    mysqli_close($conn);
}

showOneProduct($row, $categories);
