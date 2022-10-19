<?php

require_once($_SERVER['DOCUMENT_ROOT']."/php/config.php");
require($_SERVER['DOCUMENT_ROOT']."/mysql/config.php");

if(isset($_REQUEST['login']) && $_REQUEST['login'] == 'login'){
    

    // $_SESSION['username'] = 'Eun Sik';

    // header('Location: /');
    $id = $_POST['user_email'];
    $password = $_POST['user_password'];

    //  Check if inputs are empty
    if(emptyInputLogin($id, $password)){
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
        header('Location: login?error=2');
        exit();
    }
}
else{
    echo 'Oh no';

    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';
}

