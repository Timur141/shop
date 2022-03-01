<?php

error_reporting(E_ALL);

require($_SERVER['DOCUMENT_ROOT'] . '/functions/connect.php');

if (isset($_POST['id'])) {
    $id = (int)($_POST['id']);

    $sql = "delete from
                products
            where
                id = '$id'";


    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo 'success';
    } else {
        echo 'error';
    }
}

mysqli_close($conn);
