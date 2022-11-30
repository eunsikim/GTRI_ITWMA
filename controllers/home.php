<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/authentication/authentication.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/authentication/roles.php');

    $title = 'Home';

    // If the user is not logged in, redirect to login view
    if(!isLogged()){
        header('Location: login');
    }

    //echo '<pre>',var_dump($_SERVER['MODULE_PATHS']),'</pre>';

    echo $_SESSION['TWIG']->render('/views/home.html', [
        'title' => $title, //Expected by the header
        'userName' => $_SESSION['user'], //Expected for nav bar user's name display
        'userView' => checkPrivilege('view_users', $_SESSION['user_roles']), //Expected for nav bar to show (or not) the users table view
        'appName' => $_ENV['APP_NAME'], //Expected for nav bar to show name of the application
        'modules' => $_SERVER['PINNED_MODULES'], //Expected side navbar
    ]); 
