<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/app.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/authentication/authentication.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/authentication/roles.php');
    require_once($_SERVER['DOCUMENT_ROOT']."/mysql/config.php");

    $app = $_SERVER['DOCUMENT_ROOT'].'/modules/License_Tracking/app.json';

    $title = getValue($app, 'module_name');

    // If the user is not logged in, redirect to login view
    if(!isLogged()){
        header('Location: /Login');
    }

    function getLicenses($conn){
        $query = "SELECT * FROM `License_Tracking`";

        $res = mysqli_query($conn, $query);

        while($row = mysqli_fetch_object($res)){
            $licenses[]=$row;
        }

        return $licenses;
    }

    echo $_SESSION['TWIG'] ->render(getValue($app, 'view_path'), [
        'title' => $title, //Expected by the header
        'userName' => $_SESSION['user'], //Expected for nav bar user's name display
        'userView' => checkPrivilege('view_users', $_SESSION['user_roles']), //Expected for nav bar to show (or not) the users table view
        'appName' => $_ENV['APP_NAME'], //Expected for nav bar to show name of the application
        'modules' => $_SERVER['MODULE_PATHS'], //Expected side navbar

        'licenses' => getLicenses($conn)
    ]);
