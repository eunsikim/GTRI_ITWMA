<?php
    
    

    $title = 'sampleApp';
    // If the user is not logged in, redirect to login view
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/config.php');

    if(!isLogged()){
        header('Location: sampleApp');
    }

    echo $_SESSION['TWIG'] ->render('/apps/sampleApp/views/sampleApp.html') 
?>