<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/authentication/authentication.php');

    //verify user is logged in 
    if(!isLogged()){
        header('Location: login');
    }

    $title = 'Profile';

    // renders open the path mentioned
    echo $_SESSION['TWIG']->render('/views/profile.html', [
        //title that is in HTML page
        'title' => $title,
        //user name in NavBar
        'username' => $_SESSION['user'],
        'isLogged' => isLogged(),
        'admin' => $_ENV['USER_TYPE'],
        'appName' => $_ENV['APP_NAME'],
        'admin' => isAdmin()
        
    ])
?>