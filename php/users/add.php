<?php
require 'vendor/autoload.php';
require_once($_SERVER['DOCUMENT_ROOT']."/php/authentication/register.php");
require_once($_SERVER['DOCUMENT_ROOT']."/php/authentication/authentication.php");
require_once($_SERVER['DOCUMENT_ROOT'].'/mysql/config.php');
use Bcrypt\Bcrypt;

if(isset($_POST['submit']) && $_POST['submit'] == 'add'){
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(emptyInput($firstName, $lastName, $email, $password)){
        header('Location: users?error=2');
        exit();
    }

    if(idExists($conn, $email) !== false){
        header('Location: users?error=3');
        exit();
    }

    else{
        $sql = 'INSERT INTO users(id, firstName, lastName, userID, password) VALUES (UUID(), ?, ?, ?, ?);';
        $stmt = mysqli_stmt_init($conn);

        //	Check if statement fails
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: users?error=4");
            exit();
        }

        $bcrypt = new Bcrypt();
        $bcrypt_version = '2y';

        $ciphertext = $bcrypt->encrypt($password,$bcrypt_version);

        mysqli_stmt_bind_param($stmt, "ssss", $firstName, $lastName, $email, $ciphertext);

        mysqli_stmt_execute($stmt);

        $res = mysqli_stmt_get_result($stmt);
        
        mysqli_stmt_close($stmt);
        header('Location: users?res=2');
        exit();
    }
}