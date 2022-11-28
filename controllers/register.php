<?php
    require 'vendor/autoload.php';
    require_once($_SERVER['DOCUMENT_ROOT']."/php/authentication/register.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/php/authentication/authentication.php");
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/authentication/roles.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/mysql/config.php');
    use Bcrypt\Bcrypt;
    use Ramsey\Uuid\Uuid;

    $title = 'Register';
    //  If the user is logged in, redirect to home view

    if(isLogged()){
        header('Location: /');
    }

    $error = null;
    
    if(isset($_POST['register']) && $_POST['register'] == 'Register'){
        $form = array(
            'firstName' => $_POST['firstName'],
            'lastName' => $_POST['lastName'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'confirmPassword' => $_POST['confirmPassword'],
            'question1' => $_POST['question1'],
            'question2' => $_POST['question2'],
            'question3' => $_POST['question3']
        );
    
        if(emptyInput($form)){
            $error = '1';
        }
    
        else if(idExists($conn, $form['email']) !== false){
            $error = '2';
        }

        else if($form['password'] !== $form['confirmPassword']){
            $error = '3';
        }

        else if(strlen($form['password']) < 8){
            $error = '4';
        }

        else if(!str_contains($form['password'], '#') and !str_contains($form['password'], '&') and !str_contains($form['password'], '!') and !str_contains($form['password'], '^') and !str_contains($form['password'], '*') and !str_contains($form['password'], '%') and !str_contains($form['password'], '@') and !str_contains($form['password'], '$')){
            $error = '5';
        }

        else if(mb_strtoupper($form['password'], 'utf-8') == $form['password'] or mb_strtolower($form['password'], 'utf-8') == $form['password']){
            $error = '6';
        }

        else if(!preg_match('~[0-9]+~', $form['password'])){
            $error = '7';
        }
    
        else{
            $userID = Uuid::uuid4();
            $defaultRoleID = getDefaultRoleID($conn);
            // echo var_dump($defaultRoleID[0]['id']);
            $sql = "INSERT INTO users(id, firstName, lastName, email, password, question1, question2, question3) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
            $stmt = mysqli_stmt_init($conn);
    
            //	Check if statement fails
            if(!mysqli_stmt_prepare($stmt, $sql)){
                $error = '8';
            }
            else{
                $bcrypt = new Bcrypt();
                $bcrypt_version = '2y';
        
                $encryptedPassword = $bcrypt->encrypt($form['password'],$bcrypt_version);

                mysqli_stmt_bind_param($stmt, "ssssssss", $userID, $form['firstName'], $form['lastName'], $form['email'], $encryptedPassword, $form['question1'], $form['question2'], $form['question3']);
        
                mysqli_stmt_execute($stmt);
                $res = mysqli_stmt_get_result($stmt);

                $sql2 = "INSERT INTO userroles(role_id, user_id) VALUES ('".$defaultRoleID[0]['id']."', '".$userID."');";
                $res2 = mysqli_query($conn, $sql2);    
                   
                mysqli_close($conn);
                mysqli_stmt_close($stmt);
                $error = 'none';
            }           
        }
    }

    echo $_SESSION['TWIG']->render('/views/register.html', [
        'title' => 'Login',
        'error' => $error, 
        'appName' => $_ENV['APP_NAME']
    ]);
