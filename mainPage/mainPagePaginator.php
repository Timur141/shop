<?php

require($_SERVER['DOCUMENT_ROOT'] . '/mainPage/mainRequest.php');

$commonCount = 0;

if (mysqli_num_rows($result) > 0) {
    $commonCount = 0;
    while($rowCount = mysqli_fetch_assoc($result)) {
        $commonCount ++;
    }
}

$count = ceil($commonCount / 3);

if ($commonCount) {
    showPaginator($page, $count);
}

mysqli_close($conn);
