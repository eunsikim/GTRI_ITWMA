<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

//Load modules
$_SERVER['modules'] = array_values(array_filter(glob('./modules/*'), 'is_dir'));

$array = array();
foreach($_SERVER['modules'] as $module){
    array_push($array, array(
        json_decode(file_get_contents($module.'/app.json'), true)['module_name'], 
        json_decode(file_get_contents($module.'/app.json'), true)['module_route'], 
        json_decode(file_get_contents($module.'/app.json'), true)['dashboard_path'], 
        json_decode(file_get_contents($module.'/app.json'), true)['dashboard_controller_path'], 
        $module
    ));
}
$_SERVER['MODULE_PATHS'] = $array;

//Load .env file
$dotenv = Dotenv\Dotenv::createMutable('./');
$dotenv->load();

//Load Twig Templating Engine
$_SESSION['LOADER'] = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT']);
$_SESSION['TWIG'] = new \Twig\Environment($_SESSION['LOADER']);

//Load routers
require_once($_SERVER['DOCUMENT_ROOT'].'/router/routes.php');
