<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/php/authentication/login.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/php/authentication/authentication.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/mysql/config.php");
    
    $title = 'Login';

    if(isLogged()){
        header('Location: /');
    }

    $error = null;


    if(isset($_POST['login']) && $_POST['login'] == 'login'){
        $id = $_POST['user_email'];
        $password = $_POST['user_password'];
    
        //  Check if inputs are empty
        if(emptyInput($id, $password)){
            header('Location: login?error=1');
            exit();
        }
        //  Check if email and password matches
        $row = loginUser($conn, $id, $password);
        if($row !== false){
            $_SESSION['logged_in'] = true;
            $_SESSION['user'] = $row['firstName'];
            $_SESSION['role'] = 1;
            header('Location: /');
            exit();
        }
        else{
            $error = 2;
        }
    }

    if(isset($_POST['logout']) && $_POST['logout'] == 'logout'){
        $_SESSION['logged_in'] = false;
        unset($_SESSION['user']);
        header('Location: /');
    }


    echo $_SESSION['TWIG']->render('./views/login.html', [
        'title' => 'Login',
        'error' => $error, 
        'isLogged' => isLogged()
        ]) 
?>
