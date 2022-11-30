<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/authentication/authentication.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/authentication/roles.php');
    require_once($_SERVER['DOCUMENT_ROOT']."/mysql/config.php");

    $title = 'Home';

    // If the user is not logged in, redirect to login view
    if(!isLogged()){
        header('Location: login');
    }

    // Initialize widget array
    $widgetData = array();
    //Load dashboard Widget Controllers
    foreach($_SERVER['MODULE_PATHS'] as $module){
        require($module[3]);
    }
    

    echo $_SESSION['TWIG']->render('/views/home.html', [
        'title' => $title, //Expected by the header
        'userName' => $_SESSION['current_user']['firstName'], //Expected for nav bar user's name display
        'userView' => checkPrivilege('view_users', $_SESSION['user_roles']), //Expected for nav bar to show (or not) the users table view
        'rolesView' => checkPrivilege('view_roles', $_SESSION['user_roles']),
        'appName' => $_ENV['APP_NAME'], //Expected for nav bar to show name of the application
        'modules' => $_SERVER['MODULE_PATHS'], //Expected side navbar,
        'widgetData' => $widgetData
    ]); 
