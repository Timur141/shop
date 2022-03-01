<?php

if (!$success && !$error):

    include($_SERVER['DOCUMENT_ROOT'] . '/success/success.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/templates/loginForm.php');

elseif ($error):

    include($_SERVER['DOCUMENT_ROOT'] . '/success/error.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/templates/loginForm.php');

endif;

?>
