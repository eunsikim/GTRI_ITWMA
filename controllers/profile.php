<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/authentication/authentication.php');
    require_once($_SERVER['DOCUMENT_ROOT']."/php/authentication/register.php");
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/authentication/roles.php');
    include($_SERVER['DOCUMENT_ROOT']."/mysql/config.php");
    use Bcrypt\Bcrypt;

    $title = 'Profile';

    //verify user is logged in 
    if(!isLogged()){
        header('Location: login');
    }

    $error = null;

    if(isset($_POST['changeProfileInfo']) && $_POST['changeProfileInfo'] === 'Save'){
        $sql = "UPDATE users SET firstName=?, lastName=?, email=?, question1=?, question2=?, question3=? WHERE id=?;";

        $stmt = mysqli_prepare($conn, $sql);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            $error = '1';
        }

        else{
            mysqli_stmt_bind_param($stmt, "sssssss", $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['question1'], $_POST['question2'], $_POST['question3'], $_SESSION['current_user']['id']);

            mysqli_stmt_execute($stmt);

            $res = mysqli_stmt_get_result($stmt);

            mysqli_stmt_close($stmt);


            $_SESSION['current_user']['firstName'] = $_POST['firstName'];
            $_SESSION['current_user']['lastName'] = $_POST['lastName'];
            $_SESSION['current_user']['email'] = $_POST['email'];
            $_SESSION['current_user']['question1'] = $_POST['question1'];
            $_SESSION['current_user']['question2'] = $_POST['question2'];
            $_SESSION['current_user']['question3'] = $_POST['question3'];

            $error = 'none';
        }
    }

    if(isset($_POST['changePassword']) && $_POST['changePassword'] === 'Change Password'){
        $form = array(
            'oldPassword' => $_POST['oldPassword'],
            'newPassword' => $_POST['newPassword'],
            'confirmNewPassword' => $_POST['confirmNewPassword']
        );
        
        // Check if empty
        if(emptyInput($form)){
            $error = '2';
        }
        // Check New Password matches
        else if($form['newPassword'] != $form['confirmNewPassword']){
            $error = '3';
        }
        else{
            $sql = "SELECT password FROM users WHERE id='".$_SESSION['current_user']['id']."';";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);
            $oldPassowrdHash = $row['password'];

            $bcrypt = new Bcrypt();

            if($bcrypt->verify($form['oldPassword'], $oldPassowrdHash)){
                if(strlen($form['newPassword']) < 8){
                    $error = '5';
                }
        
                else if(!str_contains($form['newPassword'], '#') and !str_contains($form['newPassword'], '&') and !str_contains($form['newPassword'], '!') and !str_contains($form['newPassword'], '^') and !str_contains($form['newPassword'], '*') and !str_contains($form['newPassword'], '%') and !str_contains($form['newPassword'], '@') and !str_contains($form['newPassword'], '$')){
                    $error = '6';
                }
        
                else if(mb_strtoupper($form['newPassword'], 'utf-8') == $form['newPassword'] or mb_strtolower($form['newPassword'], 'utf-8') == $form['newPassword']){
                    $error = '7';
                }
        
                else if(!preg_match('~[0-9]+~', $form['newPassword'])){
                    $error = '8';
                }
                else{
                    $bcrypt_version = '2y';

                    $encryptedPassword = $bcrypt->encrypt($form['newPassword'],$bcrypt_version);

                    $sql = "UPDATE users SET password='".$encryptedPassword."' WHERE id='".$_SESSION['current_user']['id']."';";

                    $res = mysqli_query($conn, $sql);
                    // $row = mysqli_fetch_assoc($res);
                    mysqli_close($conn);
                    $error='none';
                }
            }
            else{
                $error = '4';
                mysqli_close($conn);
            }
        }
    }
    
    echo $_SESSION['TWIG']->render('/views/profile.html', [
        'title' => $title, //Expected by the header
        'userName' => $_SESSION['current_user']['firstName'], //Expected for nav bar user's name display
        'userView' => checkPrivilege('view_users', $_SESSION['user_roles']), //Expected for nav bar to show (or not) the users table view
        'rolesView' => checkPrivilege('view_roles', $_SESSION['user_roles']),
        'appName' => $_ENV['APP_NAME'], //Expected for nav bar to show name of the application
        'modules' => $_SERVER['MODULE_PATHS'], //Expected side navbar

        'currentUser' => $_SESSION['current_user'],
        'error' => $error,
    ]);
