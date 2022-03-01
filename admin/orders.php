<?php

error_reporting(E_ALL);

require($_SERVER['DOCUMENT_ROOT'] . '/functions/connect.php');
require($_SERVER['DOCUMENT_ROOT'] . '/functions/functions.php');

if (!isset($_GET['id'])) {
    $sql = "select
                o.*, p.price as prod_price
            from
                orders as o
            left join 
                products as p on p.id = o.product_id
            order by is_processed asc, id desc";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $out = [];
        while($row = mysqli_fetch_assoc($result))
        $out[] = $row;
    } else {
        echo 0;
    }

showOrders($out);

} elseif (isset($_GET['id']) and ($_GET['id'] != '')) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    if (isset($_GET['marker'])) {
        if ($_GET['marker'] == 1) {
            $isProcessed = ' is_processed = 1';
        } else {
            $isProcessed = ' is_processed = 0';
        }
    }
    $sql = "update
                orders
            set
                $isProcessed
            where
                id = $id";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo 1;
    } else {
        echo 0;
    }
}

mysqli_close($conn);
