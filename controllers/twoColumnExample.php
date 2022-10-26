<?php
    $title = 'Home';
    // If the user is not logged in, redirect to login view
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/config.php');

    if(isLogged()){
        header('Location: /');
    }

    echo $_SESSION['TWIG']->render('views/twoColumnExample.html', [
        'title' => 'Two Column',
        'isLogged' => isLogged()
        ]) 
?>