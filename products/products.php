<?php

error_reporting(E_ALL);

require($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php');
require($_SERVER['DOCUMENT_ROOT'] . '/functions/connect.php');


$sql = "select distinct
            p.*
        from
            products as p
        left join
            categories_products as cp on p.id = cp.product_id
        left join
            categories as c on cp.categorie_id = c.id
        order by
            p.id";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $out = [];
    while($row = mysqli_fetch_assoc($result)) {
        $out[] = $row;
    }
} else {
    echo 0;
}

$sqlCategories = "select
            p.id as prod_id, c.name as cat_name
        from
            products as p
        left join
            categories_products as cp on p.id = cp.product_id
        left join
            categories as c on cp.categorie_id = c.id
        order by
            p.id";

$resultCategories = mysqli_query($conn, $sqlCategories);

if (mysqli_num_rows($resultCategories) > 0) {
    $categories = [];
    while($rowCategories = mysqli_fetch_assoc($resultCategories)) {
        $categories[] = $rowCategories;
    }
} else {
    echo 0;
}

if ($out) {
    showProducts($out, $categories);
}

mysqli_close($conn);
