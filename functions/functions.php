<?php

function productsCount($commonCount)
{
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/templateProductsCount.php';
}
function showPaginator($page, $count)
{
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/templateMainPagePaginator.php';
}

function showMenu($menu, $ulClass = '', $itemClass = '')
{
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/template.php';
}

function showOrders($orders)
{
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/templateOrders.php';
}

function showMainPage($items)
{
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/templateMainPage.php';
}

function showProducts($products, $categories)
{
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/templateProducts.php';
}

function showOneProduct($product, $categories)
{
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/templateAdd.php';
}

/**
Возвращает TRUE, если запрошеный URL совпадает с
переданым в аргументе, в противном случае возвращает FALSE
*/
function isCurrentUrl($url)
{
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) == $url;
}

function issetUserData($orderData)
{
    if (($orderData['name'] != '') and ($orderData['surname'] != '') and ($orderData['phone'] != '') and ($orderData['email'] != '')) {
        return true;
    } else {
        return false;
    }
}

function issetOrderData($orderData)
{
    if (($orderData['city'] != '') and ($orderData['home'] != '') and ($orderData['street'] != '') and ($orderData['aprt'] != '')) {
        return true;
    } else {
        return false;
    }
}

function loggedIn()
{
    return isset($_SESSION['login']);
}

function isAutorised()
{
    if (isset($_COOKIE['login'])) {
        return true;
    }
}

function protectPage()
{
    if (!loggedIn()) {
        return header('Location: /autorisation/');
    }
}

function protectAdminPage()
{
    if (loggedIn() and ($_SESSION['userGroup'] != 'administrator')) {
        return header('Location: /autorisation/change/');
    }
}

function protectOperPage()
{
    if (loggedIn() and $_SESSION['userGroup'] != 'operator' && $_SESSION['userGroup'] != 'administrator') {
        return header('Location: /autorisation/change/');
    }
}

function protectAutorPage()
{
    if (loggedIn()) {
        return header('Location: /admin/');
    }
}

function showCount($count)
{
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/count.php';

}

function baseToJpeg($imgBaseString) {
    $filename = uniqid();
    $filename = $_SERVER['DOCUMENT_ROOT'] . '/img/products/' . $filename . '.jpg';
    $ifp = fopen($filename, 'wb'); 
    $data = explode(',', $imgBaseString);
    $data = str_replace(' ', '+', $data);
    fwrite($ifp, base64_decode($data[1]));
    fclose($ifp);
    return $filename;
}
