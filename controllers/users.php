<?php
    $title = 'Users';
    // If the user is not logged in, redirect to login view
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/authentication/authentication.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/authentication/roles.php');

    if(!isLogged()){
        header('Location: login');
    }

    require_once($_SERVER['DOCUMENT_ROOT']."/mysql/config.php");

    //  Get all users
    function getUsers($conn){
        $sqlriz = "SELECT * FROM `users`";

        $res = mysqli_query($conn,$sqlriz);

        while($row=mysqli_fetch_assoc($res))
        {
            $users[]=$row;
        }
        return $users;
    }

    function getRoles($conn){
        $sqlriz = "SELECT id, role_name FROM `roles`";

        $res = mysqli_query($conn,$sqlriz);

        while($row=mysqli_fetch_assoc($res))
        {
            $roles[]=$row;
        }
        return $roles;
    }

    function getUserRole($conn, $userID){
        $sql = "SELECT userroles.user_id, userroles.role_id, roles.role_name, users.email FROM userroles JOIN roles ON userroles.role_id = roles.id JOIN users ON userroles.user_id = users.id WHERE user_id = '".$userID."'";

        $res = mysqli_query($conn, $sql);

        while($row=mysqli_fetch_assoc($res))
        {
            $userRoles[]=$row;
        }
        return $userRoles;
    }

    function getUserRoles($conn){

        $userRoles = array();

        $users = getUsers($conn);
        foreach($users as $user){
            $userRoles[$user['id']] = getUserRole($conn, $user['id']);
        }

        return $userRoles;
    }

    echo '<pre>',var_dump(getRoles($conn)),'</pre>';
    
    $error = null;
    if(isset($_GET['error'])){
        $error = $_GET['error'];
    }

    $res = null;
    if(isset($_GET['res'])){
        $res = $_GET['res'];
    }

    echo $_SESSION['TWIG']->render('views/users.html', [
        'title' => $title, //Expected by the header
        'userName' => $_SESSION['current_user']['firstName'], //Expected for nav bar user's name display
        'userView' => checkPrivilege('view_users', $_SESSION['user_roles']), //Expected for nav bar to show (or not) the users table view
        'rolesView' => checkPrivilege('view_roles', $_SESSION['user_roles']),
        'appName' => $_ENV['APP_NAME'], //Expected for nav bar to show name of the application
        'modules' => $_SERVER['MODULE_PATHS'], //Expected side navbar

        'error' => $error, 
        'res' => $res, 
        'users' => getUsers($conn),
        'userRoles' => getUserRoles($conn),
        'roles' => getRoles($conn)
    ]);
