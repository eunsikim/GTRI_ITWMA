<?php
    $title = 'Home';
    // If the user is not logged in, redirect to login view
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/config.php');

    if(!isLogged()){
        header('Location: login');
    }

    echo $_SESSION['TWIG']->render('/views/mainTemplateExample.html', [
        'title' => 'Main',
        'userName' => $_SESSION['current_user']['firstName'],
        'isLogged' => isLogged()
        ]) 
?>