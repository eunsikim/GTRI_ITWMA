<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/php/authentication/login.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/php/authentication/authentication.php");
    require_once($_SERVER['DOCUMENT_ROOT'].'/php/authentication/roles.php');
    include($_SERVER['DOCUMENT_ROOT']."/mysql/config.php");
    
    $title = 'Login';

    if(isLogged()){
        header('Location: /');
    }

    $error = null;


    if(isset($_POST['login']) && $_POST['login'] == 'Sign In'){
        $id = $_POST['user_email'];
        $password = $_POST['user_password'];
    
        //  Check if inputs are empty
        if(emptyInput($id, $password)){
            $error = 1;
        }
        else{
            //  Check if email and password matches
            $row = loginUser($conn, $id, $password);
            if($row !== false){
                if($row['approved'] === '1'){
                    $_SESSION['logged_in'] = true;

                    $_SESSION['current_user'] = $row;

                    $_SESSION['user_roles'] = getRoles($conn, $row['id']);

                    //
                    $moduleColumn = $_SERVER['moduleColumn'];

                    $usermodule = array();
                    $sql3 = "SELECT module_name from modules JOIN usermodules on modules.id = usermodules.module_id 
                    JOIN users on users.id = usermodules.user_id where users.id = '".$_SESSION['current_user']['id']."';";
                    
                    $result = mysqli_query($conn, $sql3);
                    //echo '<pre>',var_dump($result),'</pre>';
                    while($mod = mysqli_fetch_array($result)){
                        array_push($usermodule, $mod['module_name']);
                    }
                    $unpinnedmodules = array_intersect($moduleColumn, $usermodule);
                    
                    foreach($unpinnedmodules as $value)
                    {
                        for ($i = 0; $i < $length; $i++)
                        {
                            if($value == $_SERVER['MODULE_PATHS'][$i][1])
                            {
                                array_push($_SERVER['PINNED_MODULES'], array(
                                    json_decode(file_get_contents($_SERVER['MODULE_PATHS'].'/app.json'), true)['module_name'], 
                                    json_decode(file_get_contents($_SERVER['MODULE_PATHS'].'/app.json'), true)['module_route'], 
                                    json_decode(file_get_contents($_SERVER['MODULE_PATHS'].'/app.json'), true)['dashboard_path'], 
                                    json_decode(file_get_contents($_SERVER['MODULE_PATHS'].'/app.json'), true)['dashboard_controller_path'], 
                                    $_SERVER['MODULE_PATHS']
                                ));
                            }
                        }
                    }                   

                    
                    header('Location: /');
                    exit();
                }
                else{
                    $error = 3;
                }
            }
            else{
                $error = 2;
            }
        }
    }

    if(isset($_POST['logout']) && $_POST['logout'] == 'Logout'){
        $_SESSION['logged_in'] = false;
        unset($_SESSION['current_user']);
        header('Location: /');
    }


    echo $_SESSION['TWIG']->render('./views/login.html', [
        'title' => 'Login',
        'error' => $error, 
        'appName' => $_ENV['APP_NAME']
    ]);

