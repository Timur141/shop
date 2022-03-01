<?php

require($_SERVER['DOCUMENT_ROOT'] . '/mainPage/mainRequest.php');

if (mysqli_num_rows($result) > 0) {
    $commonCount = 0;
    while($rowCount = mysqli_fetch_assoc($result)) {
        $commonCount ++;
    }
} else {
    $commonCount = 0;
}

productsCount($commonCount);

mysqli_close($conn);
