<?php
    require_once ('loader.php');
    if (!isLogged()) {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/loginPage.php', true, 303);
    }
    logout();
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/loginPage.php', true, 303);
?>
