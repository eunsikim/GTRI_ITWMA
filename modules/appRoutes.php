<?php
    foreach($_SERVER['modules'] as $module){
        get('/'.str_replace('./modules/', '', $module), $module."/controllers/".str_replace('./modules/', '', $module).'.php');
    }