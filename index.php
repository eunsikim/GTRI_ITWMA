<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

$_SERVER['modules'] = array_values(array_filter(glob('./modules/*'), 'is_dir'));

//Load .env file
$dotenv = Dotenv\Dotenv::createMutable('./');
$dotenv->load();

//Load Twig Templating Engine
$_SESSION['LOADER'] = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT']);
$_SESSION['TWIG'] = new \Twig\Environment($_SESSION['LOADER']);

//Load routers
require_once($_SERVER['DOCUMENT_ROOT'].'/router/routes.php');
