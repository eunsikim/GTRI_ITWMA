<?php

require_once("{$_SERVER['DOCUMENT_ROOT']}/router.php");
//  GET
// get('/index', './index.php');
get('/', './views/home.php');
get('/login', './views/login.php');
get('/register', './views/register.php');

//  POST
post('/login', './php/authentication/login.php');
post('/logout', './php/authentication/logout.php');
post('/register', './php/authentication/register.php');

// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
any('/404','views/404.php');
