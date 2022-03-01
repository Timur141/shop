<?php

session_start();

if (isset($_POST['logout'])) {

    session_destroy();
    unset($_SESSION['login']);
    unset($_SESSION['userGroup']); 

}
