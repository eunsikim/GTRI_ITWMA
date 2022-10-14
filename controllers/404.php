<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

    $loader = new \Twig\Loader\FilesystemLoader('./views');

    $twig = new \Twig\Environment($loader);

    $title = 'Error';

    echo $twig->render('404.html', [
        'title' => 'Login',
        ]) 
?>