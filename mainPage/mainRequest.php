<?php

error_reporting(E_ALL);

require($_SERVER['DOCUMENT_ROOT'] . '/functions/connect.php');
require($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php');

$maxPrice = (int)$_POST['maxPrice'];
if ($maxPrice == 0) {
    $maxPrice = 1000000;
}

$minPrice = (int)$_POST['minPrice'];

$priceOrName = $_POST['priceorname'];
if ($priceOrName == 'price') {
    $priceOrName = 'p.price';
} else {
    $priceOrName = 'p.name';
}

$sortDir = $_POST['sortdir'];
if ($sortDir == 'desc') {
    $sortDir = 'desc';
} else {
    $sortDir = 'asc';
}

if (isset($_POST['new'])) {
    $new = $_POST['new'];
} else {
    $new = 'off';
}

if (isset($_POST['sale'])) {
    $sale = $_POST['sale'];
} else {
    $sale = 'off';
}

if ($new === 'on' and $sale === 'on') {
    $newOrSale = 'and (p.is_new = 1 and p.is_sale = 1)';
} elseif ($sale === 'on') {
    $newOrSale = 'and p.is_sale = 1';
} elseif ($new === 'on') {
    $newOrSale = 'and p.is_new = 1';
} else {
    $newOrSale = '';
}


if (isset($_POST['categorie'])) {
    if (($_POST['categorie']) == '') {
        $categorie = '';
    } elseif (($_POST['categorie']) == 'women') {
        $categorie = ' and c.id = 1';
    } elseif (($_POST['categorie']) == 'men') {
        $categorie = ' and c.id = 2';
    } elseif (($_POST['categorie']) == 'kids') {
        $categorie = ' and c.id = 3';
    } elseif (($_POST['categorie']) == 'acessoires') {
        $categorie = ' and c.id = 4';
    }
} else {
    $categorie = '';

}

if (isset($_POST['page'])) {
    $page = $_POST['page'];
} else {
    $page = 1;
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
            (p.price between $minPrice and $maxPrice)
            $newOrSale $categorie";
            //echo $sql;

$result = mysqli_query($conn, $sql);
