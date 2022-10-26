<?php
    $title = 'Home';
    // If the user is not logged in, redirect to login view
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/config.php');

    if(!isLogged()){
        header('Location: login');
    }

    echo $_SESSION['TWIG']->render('/views/home.html', [
        'title' => 'Home',
        'userName' => $_SESSION['user'],
        'isLogged' => isLogged(),
        'admin' => $_ENV['USER_TYPE'],
        'appName' => $_ENV['APP_NAME']
        ]) 
?>