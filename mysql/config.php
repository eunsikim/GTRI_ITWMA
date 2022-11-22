<?php

$DB_SERVER = $_ENV['DB_SERVER'];
$DB_USERNAME = $_ENV['DB_USERNAME'];
$DB_PASSWORD = $_ENV['DB_PASSWORD'];
$DB_NAME = $_ENV['DB_NAME'];

$conn = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

if($conn === false){
    die('ERROR: Could not connect. '.mysqli_connect_error());
}