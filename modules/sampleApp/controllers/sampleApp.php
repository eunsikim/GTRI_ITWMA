<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/path.php');
    
    require_once($phpAuthFile);

    require_once($modules.'/sampleApp/app.php');

    $title = $moduleName;
    // If the user is not logged in, redirect to login view

    if(!isLogged()){
        header('Location: /login');
    }

    echo $_SESSION['TWIG'] ->render($view, [
        'isLogged' => isLogged(),
        'title' => $title,
        'userName' => $_SESSION['user'],
        'appName' => $_ENV['APP_NAME']
    ]); 
