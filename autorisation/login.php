<?php

$userLogin = '';
$userPassword = '';
$success = false;
$error = false;

require ($_SERVER['DOCUMENT_ROOT'] . '/functions/connect.php');

if (isset($_SESSION['login'])) {
    setcookie('login', $_SESSION['login'], time()+2592000, '/');
}


if (isset($_POST['send'])) {

    $userPassword = $_POST['password'];
    $userLogin = mysqli_real_escape_string($conn, $_POST['login']);

    $sqlPassword = "select
                        password, id from users
                    where
                        email = '$userLogin'
                    ";

    $resultPassword = mysqli_query($conn, $sqlPassword);
    $rowPassword = mysqli_fetch_assoc($resultPassword);

    $savedPassword = $rowPassword['password'];
    $id = $rowPassword['id'];

    $sqlGroups = "select
                        group_id
                    from
                        group_user
                    where
                        user_id = '$id'
                    ";

    $resultGroups = mysqli_query($conn, $sqlGroups);

    if (mysqli_num_rows($resultGroups) > 0) {

        $out = [];
        while($row = mysqli_fetch_assoc($resultGroups)) {
            $out[] = $row;
        }
    } else {
        echo 'Ошибка запроса к БД';
    }

    foreach ($out as $key) {
        $groupId[] = $key['group_id'];
    }

    if (in_array(2, $groupId)) {
        $userGroup = 'administrator';
    } elseif (in_array(1, $groupId) && !in_array(2, $groupId)) {
        $userGroup = 'operator';
    }

    if (password_verify($userPassword, $savedPassword)) {

        $_SESSION['login'] = $userLogin;
        $_SESSION['userGroup'] = $userGroup;
        
        setcookie('login', $_SESSION['login'], time()+2592000, '/');

        $success = true;

    } else {
        $error = true;
        //$userPassword = $_POST['password'];
        //$userLogin = $_POST['login'];
    }

}

mysqli_close($conn);
