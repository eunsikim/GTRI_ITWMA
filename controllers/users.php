<?php
    $title = 'Users';
    // If the user is not logged in, redirect to login view
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/authentication/authentication.php');

    if(!isLogged()){
        header('Location: login');
    }
    elseif(!isLogged()){
        header('Location: /');
    }

    require_once($_SERVER['DOCUMENT_ROOT']."/mysql/config.php");

    //  Get all users
    function getUsers($conn){
        $sqlriz = "Select * FROM `users`";

        $res = mysqli_query($conn,$sqlriz);

        while($row=mysqli_fetch_object($res))
        {
            $users[]=$row;
        }

        return $users;
    }
    
    $error = null;
    if(isset($_GET['error'])){
        $error = $_GET['error'];
    }

    $res = null;
    if(isset($_GET['res'])){
        $res = $_GET['res'];
    }

    echo $_SESSION['TWIG']->render('views/users.html', [
        'title' => $title,
        'error' => $error, 
        'res' => $res, 
        'userName' => $_SESSION['user'],
        'isLogged' => isLogged(),
        'users' => getUsers($conn),
        'appName' => $_ENV['APP_NAME'],
        'userType' => $_ENV['USER_TYPE'],
        'admin' => isAdmin()
        ]) 
?>