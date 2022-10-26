<?php
    require 'vendor/autoload.php';
    require_once($_SERVER['DOCUMENT_ROOT']."/php/authentication/register.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/php/authentication/authentication.php");
    require_once($_SERVER['DOCUMENT_ROOT'].'/mysql/config.php');
    use Bcrypt\Bcrypt;

    $title = 'Register';
    //  If the user is logged in, redirect to home view

    if(isLogged()){
        header('Location: /');
    }

    $error = null;
    
    if(isset($_POST['register']) && $_POST['register'] == 'register'){
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        if(emptyInput($firstName, $lastName, $email, $password)){
            $error = '1';
        }
    
        else if(idExists($conn, $email) !== false){
            $error = '2';
        }
    
        else{
            $sql = 'INSERT INTO users(id, firstName, lastName, userID, password) VALUES (UUID(), ?, ?, ?, ?);';
            $stmt = mysqli_stmt_init($conn);
    
            //	Check if statement fails
            if(!mysqli_stmt_prepare($stmt, $sql)){
                $error = '3';
            }
    
            $bcrypt = new Bcrypt();
            $bcrypt_version = '2y';
    
            $ciphertext = $bcrypt->encrypt($password,$bcrypt_version);
    
            mysqli_stmt_bind_param($stmt, "ssss", $firstName, $lastName, $email, $ciphertext);
    
            mysqli_stmt_execute($stmt);
    
            $res = mysqli_stmt_get_result($stmt);
            
            mysqli_stmt_close($stmt);
            $error = 'none';
        }
    }

    echo $_SESSION['TWIG']->render('/views/register.html', [
        'title' => 'Login',
        'error' => $error, 
        'isLogged' => isLogged()
        ]) 
?>
