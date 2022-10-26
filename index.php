<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

//Load .env file
$dotenv = Dotenv\Dotenv::createMutable('./');
$dotenv->load();

//Load Twig Templating Engine
$_SESSION['LOADER'] = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT']);
$_SESSION['TWIG'] = new \Twig\Environment($_SESSION['LOADER']);

//Load routers
require_once('./routes.php');
require_once('./sampleApp.php');