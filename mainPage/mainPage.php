<?php

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

if (($_POST['new']) === 'on' and $_POST['sale'] === 'on') {
    $newOrSale = 'and (p.is_new = 1 and p.is_sale = 1)';
} elseif (($_POST['sale']) === 'on') {
    $newOrSale = 'and p.is_sale = 1';
} elseif ($_POST['new'] === 'on') {
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
}

$page =  ($_POST['page'] ? (int)$_POST['page'] : 1);
$start = (($page - 1) * 3);

$limitString = " limit $start, 3";


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
            $newOrSale $categorie
        order by
            $priceOrName $sortDir
            $limitString";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $out = [];
    while($row = mysqli_fetch_assoc($result)) {
        $out[] = $row;
    }
} else {
    echo 'Ошибка, пропробуйте изменить параметры запроса.';
}

if ($out) {
    showMainPage($out);
}

mysqli_close($conn);
