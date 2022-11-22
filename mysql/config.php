<?php

if($_ENV['DB_MODE'] == 'production'){
    $DB_SERVER = $_ENV['DB_SERVER'];
    $DB_USERNAME = $_ENV['DB_USERNAME'];
    $DB_PASSWORD = $_ENV['DB_PASSWORD'];
    $DB_NAME = $_ENV['DB_NAME'];
}
else if($_ENV['DB_MODE'] == 'development'){
    $DB_SERVER = $_ENV['DB_SERVER_DEV'];
    $DB_USERNAME = $_ENV['DB_USERNAME_DEV'];
    $DB_PASSWORD = $_ENV['DB_PASSWORD_DEV'];
    $DB_NAME = $_ENV['DB_NAME_DEV'];
}


$conn = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

if($conn === false){
    die('ERROR: Could not connect. '.mysqli_connect_error());
}