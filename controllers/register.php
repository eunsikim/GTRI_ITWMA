<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

    $loader = new \Twig\Loader\FilesystemLoader('./views');

    $twig = new \Twig\Environment($loader);

    $title = 'Register';
    //  If the user is logged in, redirect to home view
    require_once($_SERVER['DOCUMENT_ROOT']."/php/config.php");

    if(isLogged()){
        header('Location: /');
    }

    $error = null;
<<<<<<< Updated upstream
    if(isset($_GET['error'])){
        $error = $_GET['error'];
=======
    
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
>>>>>>> Stashed changes
    }

    echo $twig->render('register.html', [
        'title' => 'Login',
        'error' => $error, 
        'isLogged' => isLogged()
        ]) 
?>
