<?php

if(isset($_POST['logout']) && $_POST['logout'] == 'logout'){
    $_SESSION['logged_in'] = false;
    unset($_SESSION['user']);
    header('Location: /');
}