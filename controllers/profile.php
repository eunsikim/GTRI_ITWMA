<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/authentication/authentication.php');
    require_once($_SERVER['DOCUMENT_ROOT']."/mysql/config.php");

    //verify user is logged in 
    if(!isLogged()){
        header('Location: login');
    }

    $title = 'Profile';

    //this will set up the connection with mysql
    require_once($_SERVER['DOCUMENT_ROOT']."/mysql/config.php");
    //this will take to config php
    //config php has this path 
    //$conn = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);


    //traverse through all users
    
    function getCurrentUser($conn){
        $sqlriz = "Select * FROM `users` WHERE users.id = '".$_SESSION['userID']."'";

        $res = mysqli_query($conn,$sqlriz);

        $row=mysqli_fetch_object($res);

        // while($row=mysqli_fetch_object($res))
        // {
        //     $users=$row;
        // }
        return $row;
    }
    
//renders (supplies) the path mentioned
    echo $_SESSION['TWIG']->render('/views/profile.html', [
        //title that is in HTML page
        'title' => $title,
        //user name in NavBar
        'username' => $_SESSION['user'],
        'isLogged' => isLogged(),
        'admin' => $_ENV['USER_TYPE'],
        'appName' => $_ENV['APP_NAME'],
        'admin' => isAdmin(),
        'user' => getCurrentUser($conn)
    ])
?>