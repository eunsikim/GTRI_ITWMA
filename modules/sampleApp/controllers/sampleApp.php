<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/app.php');
    
    require_once($phpAuthFile);

    $app = $_SERVER['DOCUMENT_ROOT'].'/modules/sampleApp/app.json';

    $title = getValue($app, 'module_name');
    // If the user is not logged in, redirect to login view

    if(!isLogged()){
        header('Location: /login');
    }
    // getValue($path, 'view_path')
    echo $_SESSION['TWIG'] ->render(getValue($app, 'view_path'), [
        'isLogged' => isLogged(),
        'title' => $title,
        'userName' => $_SESSION['user'],
        'appName' => $_ENV['APP_NAME'],
        'modules' => $_SERVER['MODULE_PATHS']
    ]); 
