<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/php/config.php");
    // require_once($_SERVER['DOCUMENT_ROOT']."/mysql/config.php");
    $title = 'Login';

    if(isLogged()){
        header('Location: /');
    }

    $error = null;
    if(isset($_GET['error'])){
        $error = $_GET['error'];
    }




    echo $_SESSION['TWIG']->render('/views/login.html', [
        'title' => 'Login',
        'error' => $error, 
        'isLogged' => isLogged()
        ]) 
?>
