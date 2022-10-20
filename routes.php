<?php

require_once($_SERVER['DOCUMENT_ROOT']."/router.php");
require_once($_SERVER['DOCUMENT_ROOT'].'/php/loadDotEnv.php');
//  GET
// get('/index', './index.php');
get('/', './controllers/home.php');
get('/login', './controllers/login.php');
get('/register', './controllers/register.php');
get('/main', './controllers/mainTemplateExample.php');
get('/twoCol', './controllers/twoColumnExample.php');

if(isset($_SESSION['role']) && $_SESSION['role'] == 1){
    get('/users', './controllers/users.php');
}

//  POST
post('/login', './php/authentication/login.php');
post('/logout', './php/authentication/logout.php');
post('/register', './php/authentication/register.php');
post('/edit', './php/users/edit.php');
post('/remove', './php/users/remove.php');
post('/add', './php/users/add.php');

// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
any('/404','./controllers/404.php');
