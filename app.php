<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
    $controler = $_SERVER['DOCUMENT_ROOT'].'/controllers';
    $modules = $_SERVER['DOCUMENT_ROOT'].'/modules';

    $php = $_SERVER['DOCUMENT_ROOT'].'/php';
    $phpAuth = $php.'/authentication';
    $phpAuthFile = $phpAuth.'/authentication.php';

    function getValue($path, $key){
        return json_decode(file_get_contents($path), true)[$key];
    }