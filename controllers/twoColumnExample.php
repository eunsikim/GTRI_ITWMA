<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

    $loader = new \Twig\Loader\FilesystemLoader('./views');

    $twig = new \Twig\Environment($loader);

    $title = 'Home';
    // If the user is not logged in, redirect to login view
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/config.php');

    if(isLogged()){
        header('Location: /');
    }

    echo $twig->render('twoColumnExample.html', [
        'title' => 'Two Column',
        'isLogged' => isLogged()
        ]) 
?>