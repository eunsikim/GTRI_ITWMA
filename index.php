<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

$_SESSION['LOADER'] = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT']);

$_SESSION['TWIG'] = new \Twig\Environment($_SESSION['LOADER']);

require_once('./routes.php');
require_once('./sampleApp.php');



// echo $_SERVER['DOCUMENT_ROOT'];
