<?php

    session_start();

    date_default_timezone_set('America/Sao_Paulo');

    require('vendor/autoload.php');
    $app = new RedeSocial\Application();

    define('INCLUDE_PATH_STATIC','http://localhost/projeto_rede_social/RedeSocial/Views/Pages/');
    define('INCLUDE_PATH','http://localhost/projeto_rede_social/');

    $app->run();

?>