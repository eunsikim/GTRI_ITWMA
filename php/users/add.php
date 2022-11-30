<?php
require 'vendor/autoload.php';
require_once($_SERVER['DOCUMENT_ROOT']."/php/authentication/register.php");
require_once($_SERVER['DOCUMENT_ROOT']."/php/authentication/authentication.php");
require_once($_SERVER['DOCUMENT_ROOT'].'/mysql/config.php');
use Bcrypt\Bcrypt;
use Ramsey\Uuid\Uuid;

if(isset($_POST['submit']) && $_POST['submit'] == 'add'){
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $question1 = $_POST['question1'];
    $question2 = $_POST['question2'];
    $question3 = $_POST['question3'];

    if(emptyInput($firstName, $lastName, $email, $password)){
        header('Location: users?error=2');
        exit();
    }

    if(idExists($conn, $email) !== false){
        header('Location: users?error=3');
        exit();
    }

    else{
        $userID = Uuid::uuid4();
        $defaultRoleID = getDefaultRoleID($conn);
        $sql = "INSERT INTO users(id, firstName, lastName, email, password, question1, question2, question3) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);

        //	Check if statement fails
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: users?error=4");
            exit();
        }

        $bcrypt = new Bcrypt();
        $bcrypt_version = '2y';

        $ciphertext = $bcrypt->encrypt($password,$bcrypt_version);

        mysqli_stmt_bind_param($stmt, "ssssssss", $userID, $firstName, $lastName, $email, $ciphertext, $question1, $question2, $question3);

        mysqli_stmt_execute($stmt);

        $res = mysqli_stmt_get_result($stmt);

        $sql2 = "INSERT INTO userroles(role_id, user_id) VALUES ('".$defaultRoleID[0]['id']."', '".$userID."');";
        $res2 = mysqli_query($conn, $sql2);    
            
        mysqli_close($conn);
        mysqli_stmt_close($stmt);
        header('Location: users?res=2');
        exit();
    }
}