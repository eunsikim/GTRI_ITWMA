<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/php/authentication/login.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/php/authentication/authentication.php");
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/authentication/roles.php');
    require_once($_SERVER['DOCUMENT_ROOT']."/mysql/config.php");
    
    $title = 'Login';

    if(isLogged()){
        header('Location: /');
    }

    $error = null;


    if(isset($_POST['login']) && $_POST['login'] == 'Sign In'){
        $id = $_POST['user_email'];
        $password = $_POST['user_password'];
    
        //  Check if inputs are empty
        if(emptyInput($id, $password)){
            $error = 1;
        }
        else{
            //  Check if email and password matches
            $row = loginUser($conn, $id, $password);
            if($row !== false){
                if($row['approved'] === '1'){
                    $_SESSION['logged_in'] = true;
                    $_SESSION['user'] = $row['firstName'];
                    $_SESSION['approved'] = $row['approved'];
                    $_SESSION['user_roles'] = getRoles($conn, $row['id']);
                    header('Location: /');
                    exit();
                }
                else{
                    $error = 3;
                }
            }
            else{
                $error = 2;
            }
        }
    }

    if(isset($_POST['logout']) && $_POST['logout'] == 'Logout'){
        $_SESSION['logged_in'] = false;
        unset($_SESSION['user']);
        header('Location: /');
    }


    echo $_SESSION['TWIG']->render('./views/login.html', [
        'title' => 'Login',
        'error' => $error, 
        'appName' => $_ENV['APP_NAME']
    ]);

