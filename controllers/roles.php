<?php
    $title = 'Roles';

    require_once($_SERVER['DOCUMENT_ROOT'].'/php/authentication/authentication.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/authentication/roles.php');
    require_once($_SERVER['DOCUMENT_ROOT']."/mysql/config.php");
    use Ramsey\Uuid\Uuid;

    if(!isLogged()){
        header('Location: login');
    }

    function getRoles($conn){
        $sql = "SELECT * FROM `roles`";

        $res = mysqli_query($conn, $sql);

        while($row=mysqli_fetch_assoc($res))
        {
            $roles[]=$row;
        }
        return $roles;
    }
    function generateSet($form){
        $query = '';

        foreach($form as $data){
            if($data !== 'id' && $data !== 'role_name'){
                $query .= ', '.$data.'=?';
            }
        }

        return $query;
    }
    function generateSetInsert($form){
        $query = '';

        foreach($form as $data){
            if($data !== 'id' && $data !== 'role_name'){
                $query .= ', ?';
            }
        }

        return $query;
    }
    function generateTypes($form){
        $types = '';

        foreach($form as $data){
            $query .= 's';
        }

        return $query;
    }

    $roles = getRoles($conn);

    $error = null;

    if(isset($_POST['edit']) && $_POST['edit'] === 'edit'){
        $form = array();
        array_push($form, $_POST['role_name']);
        foreach(array_keys($roles[0]) as $data){
            if($data !== 'id' && $data !== 'role_name'){
                if(isset($_POST[$data])){
                    array_push($form, 1);
                }
                else{
                    array_push($form, 0);
                }
            }
        }
        array_push($form, $_POST['id']);

        $sql = 'UPDATE roles SET role_name=?'.generateSet(array_keys($roles[0])).' WHERE id=?';

        $stmt = mysqli_prepare($conn, $sql);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            $error = 1;
        }
        else{
            mysqli_stmt_bind_param($stmt, generateTypes($form), ...$form);

            mysqli_stmt_execute($stmt);

            $res = mysqli_stmt_get_result($stmt);

            mysqli_stmt_close($stmt);

            $roles = getRoles($conn);
        }
    }

    if(isset($_POST['add']) && $_POST['add'] == 'add'){
        if(!isset($_POST['role_name']) && empty($_POST['role_name'])){
            $error = 2;
        }
        else{
            $form = array();
            array_push($form, Uuid::uuid4());
            array_push($form, $_POST['role_name']);
            foreach(array_keys($roles[0]) as $data){
                if($data !== 'id' && $data !== 'role_name'){
                    if(isset($_POST[$data])){
                        array_push($form, 1);
                    }
                    else{
                        array_push($form, 0);
                    }
                }
            }

            $sql = "INSERT INTO roles VALUES (?, ?".generateSetInsert(array_keys($roles[0])).");";
            
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql)){
                $error = 1;
            }
            else{
                mysqli_stmt_bind_param($stmt, generateTypes($form), ...$form);

                mysqli_stmt_execute($stmt);

                $res = mysqli_stmt_get_result($stmt);

                mysqli_stmt_close($stmt);

                $roles = getRoles($conn);
            }
        }
    }

    if(isset($_POST['remove']) && $_POST['remove'] == 'remove'){
        $id = $_POST['id'];
        // Delete from userRoles
        $sql = 'DELETE FROM userroles WHERE role_id = ?';
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            $error = 1;
        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $id);

            mysqli_stmt_execute($stmt);

            // mysqli_stmt_close($stmt);
        }
        // Delete from Roles
        $sql = "DELETE FROM roles WHERE id=?";

        $stmt = mysqli_stmt_init($conn);
        // $stmt = mysqli_prepare($conn, $sql);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            $error = 1;
        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $id);

            mysqli_stmt_execute($stmt);


            mysqli_stmt_close($stmt);
        }

        $roles = getRoles($conn);
    }

    echo $_SESSION['TWIG']->render('views/roles.html', [
        'title' => $title, //Expected by the header
        'userName' => $_SESSION['current_user']['firstName'], //Expected for nav bar user's name display
        'userView' => checkPrivilege('view_users', $_SESSION['user_roles']), //Expected for nav bar to show (or not) the users table view
        'rolesView' => checkPrivilege('view_roles', $_SESSION['user_roles']),
        'appName' => $_ENV['APP_NAME'], //Expected for nav bar to show name of the application
        'modules' => $_SERVER['MODULE_PATHS'], //Expected side navbar

        'roleColumns' => array_keys($roles[0]),
        'roles' => $roles
    ]);