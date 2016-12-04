<?php
    try {
        require_once dirname(__FILE__) . '/connect.php';
        require_once dirname(__FILE__) . '/session.php';
        require_once dirname(__FILE__) . '/functions.php';
        authenticate();
    } catch (Exception $e) {
        echo getError($e->getMessage());
        exit;
    }
?>
