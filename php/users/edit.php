<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/mysql/config.php');

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

    // Handles Update Query
    if(isset($_POST['edit']) && $_POST['edit'] == 'edit'){
        
        $id = $_POST['id'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];

        if(isset($_POST['approved'])){
            $approved = 1;
        }
        else{
            $approved = 0;
        }

        $row = explode(', ', $_POST['row']);

        if(empty($firstName)){
            $firstName = $row[0];
        }
        if(empty($lastName)){
            $lastName = $row[1];
        }
        if(empty($email)){
            $email = $row[2];
        }
       
        $sql = 'UPDATE users SET firstName=?, lastName=?, email=?, approved=? WHERE id=?';
        $stmt = mysqli_prepare($conn, $sql);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header('Location: users?error=1');
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sssss", $firstName, $lastName, $email, $approved, $id);

        mysqli_stmt_execute($stmt);

        $res = mysqli_stmt_get_result($stmt);

        mysqli_stmt_close($stmt);

        header('Location: /users?res=1');
        // comment
        exit();
    }


