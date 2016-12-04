<?php

    require 'dibi.min.php';

    date_default_timezone_set('Europe/Prague');

    try {
        dibi::connect(array(
            'driver'   => 'mysqli',
            'host'     => 'localhost',
            'port'     => '9999',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'database' => 'book-a-lesson'
        ));
    } catch (Exception $e) {
        echo '<p class="error"><strong>ERROR:</strong> ' . $e->getMessage() . '</p>';
    }

?>
