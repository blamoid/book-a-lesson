<?php
    session_name('SID');
    session_start();
    if (!isset($_COOKIE['SID']) && empty($_SESSION)) {
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['ua'] = $_SERVER['HTTP_USER_AGENT'];
    } elseif (!isset($_SESSION['ip']) || !isset($_SESSION['ua'])) {
        session_regenerate_id(TRUE);
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['ua'] = $_SERVER['HTTP_USER_AGENT'];
    } elseif ($_SESSION['ip'] != $_SERVER['REMOTE_ADDR'] || $_SESSION['ua'] != $_SERVER['HTTP_USER_AGENT']) {
        session_regenerate_id(FALSE);
        $_SESSION = array();
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['ua'] = $_SERVER['HTTP_USER_AGENT'];
    }
?>
