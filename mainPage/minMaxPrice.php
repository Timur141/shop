<?php

error_reporting(E_ALL);

require($_SERVER['DOCUMENT_ROOT'] . '/functions/connect.php');
require($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php');

$newOrSale = '';

if (isset($_POST['new'])) {
    if ($_POST['new'] === 'on') {
        $newOrSale = 'and p.is_new = 1';
    }
}

if (isset($_POST['sale'])) {
    if ($_POST['sale'] === 'on') {
        $newOrSale = 'and p.is_sale = 1';
    }
}

if (isset($_POST['new']) and isset($_POST['sale'])) {
    if (($_POST['new']) === 'on' and $_POST['sale'] === 'on') {
        $newOrSale = 'and (p.is_new = 1 and p.is_sale = 1)';
    }
}

$categorie = '';

if (isset($_POST['categorie'])) {
    if (($_POST['categorie']) == 'women') {
        $categorie = ' and c.id = 1';
    } elseif (($_POST['categorie']) == 'men') {
        $categorie = ' and c.id = 2';
    } elseif (($_POST['categorie']) == 'kids') {
        $categorie = ' and c.id = 3';
    } elseif (($_POST['categorie']) == 'acessoires') {
        $categorie = ' and c.id = 4';
    }
}

$sql = "select distinct
            p.*
        from
            products as p
        left join
            categories_products
            as cp on p.id = cp.product_id
        left join
            categories
            as c on cp.categorie_id = c.id
        where
            (p.price between 0 and 1000000)
            $newOrSale $categorie";
            //echo $sql;

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $outPrices = [];
    while($rowPrices = mysqli_fetch_assoc($result)) {
        $outPrices[] = $rowPrices['price'];
    }
}

$minPrice = min($outPrices) ? min($outPrices) : 0;
$maxPrice = max($outPrices) ? max($outPrices) : 1000000;
$minMaxPrice = [];
$minMaxPrice = ['min' => $minPrice, 'max' => $maxPrice];

if ($minMaxPrice) {
    echo json_encode($minMaxPrice);
}

mysqli_close($conn);
