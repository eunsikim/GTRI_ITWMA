<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/mysql/config.php');

    // Handles Update Query
    if(isset($_POST['edit']) && $_POST['edit'] == 'edit'){
        
        $id = $_POST['id'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];

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
        $sql = 'UPDATE users SET firstName=?, lastName=?, userID=? WHERE id=?';
        $stmt = mysqli_prepare($conn, $sql);
        echo $sql;
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header('Location: users?error=1');
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ssss", $firstName, $lastName, $email, $id);

        mysqli_stmt_execute($stmt);

        $res = mysqli_stmt_get_result($stmt);

        mysqli_stmt_close($stmt);

        header('Location: /users?res=1');
        exit();
    }


