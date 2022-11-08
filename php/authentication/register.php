<?php
<<<<<<< Updated upstream
require 'vendor/autoload.php';
use Bcrypt\Bcrypt;

if(isset($_POST['register']) && $_POST['register'] == 'register'){
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/config.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/mysql/config.php');
    

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(emptyInputRegister($firstName, $lastName, $email, $password)){
        header('Location: register?error=1');
        exit();
    }

    if(idExists($conn, $email) !== false){
        header('Location: register?error=2');
        exit();
    }

    else{
        $sql = 'INSERT INTO users(id, firstName, lastName, userID, password) VALUES (UUID(), ?, ?, ?, ?);';
        $stmt = mysqli_stmt_init($conn);

        //	Check if statement fails
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: login?error=3");
            exit();
        }

        $bcrypt = new Bcrypt();
        $bcrypt_version = '2y';

        $ciphertext = $bcrypt->encrypt($password,$bcrypt_version);

        mysqli_stmt_bind_param($stmt, "ssss", $firstName, $lastName, $email, $ciphertext);

        mysqli_stmt_execute($stmt);

        $res = mysqli_stmt_get_result($stmt);
        
        mysqli_stmt_close($stmt);
        header('Location: register?error=none');
        exit();
    }
}
=======
function emptyInput($firstName, $lastName, $email, $password){
	if(empty($firstName) || empty($lastName) || empty($email) || empty($password)){
		return true;
	}
	return false;
}
>>>>>>> Stashed changes
