<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

    $loader = new \Twig\Loader\FilesystemLoader('./views');

    $twig = new \Twig\Environment($loader);

    $title = 'Register';
    //  If the user is logged in, redirect to home view
    require_once($_SERVER['DOCUMENT_ROOT']."/php/config.php");

    if(isLogged()){
        header('Location: /');
    }

    $error = null;
    if(isset($_GET['error'])){
        $error = $_GET['error'];
    }

    echo $twig->render('register.html', [
        'title' => 'Login',
        'error' => $error, 
        'isLogged' => isLogged()
        ]) 
?>
