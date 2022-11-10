<?php
    
    require_once($_SERVER['DOCUMENT_ROOT']."/php/authentication/authentication.php");

    $title = 'sampleApp';
    // If the user is not logged in, redirect to login view

    if(!isLogged()){
        header('Location: sampleApp');
    }

    echo $_SESSION['TWIG'] ->render('/modules/sampleApp/views/sampleApp.html', [
        'isLogged' => isLogged(),
        'title' => $title,
        'userName' => $_SESSION['user'],
        'appName' => $_ENV['APP_NAME']
        ]) 
?>