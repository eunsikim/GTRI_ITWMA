<?php 
    $title = 'Error';

    echo $_SESSION['TWIG']->render('/views/404.html', [
        'title' => 'Login',
        ]) 
?>