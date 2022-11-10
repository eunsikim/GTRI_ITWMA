<?php
    
    require_once($_SERVER['DOCUMENT_ROOT']."/php/authentication/authentication.php");

    $title = 'License_Tracking';
    // If the user is not logged in, redirect to login view

    if(!isLogged()){
        header('Location: License_Tracking');
    }

    echo $_SESSION['TWIG'] ->render('/modules/License_Tracking/views/license.html', [
        'isLogged' => isLogged(),
        'title' => $title,
        'userName' => $_SESSION['user'],
        'appName' => $_ENV['APP_NAME']
        ]) 
?>