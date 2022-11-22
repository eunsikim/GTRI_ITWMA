<?php

require_once './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createMutable('./');
$dotenv->load();

//Load modules
$modules = array_values(array_filter(glob('./modules/*'), 'is_dir'));

$migration_paths = array();
array_push($migration_paths, '%%PHINX_CONFIG_DIR%%/db/migrations');
foreach($modules as $module){
    array_push($migration_paths, 
        json_decode(file_get_contents($module.'/app.json'), true)['migration_path']
    );
}

return
[
    'paths' => [
        'migrations' => $migration_paths,
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => $_ENV['DB_MODE'],
        'production' => [
            'adapter' => 'mysql',
            'host' => $_ENV['DB_HOST'],
            'name' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USERNAME'],
            'pass' => $_ENV['DB_PASSWORD'],
            'port' => $_ENV['DB_PORT'],
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'mysql',
            'host' => $_ENV['DB_HOST_DEV'],
            'name' => $_ENV['DB_NAME_DEV'],
            'user' => $_ENV['DB_USERNAME_DEV'],
            'pass' => $_ENV['DB_PASSWORD_DEV'],
            'port' => $_ENV['DB_PORT_DEV'],
            'charset' => 'utf8',
        ],
        // 'testing' => [
        //     'adapter' => 'mysql',
        //     'host' => 'localhost',
        //     'name' => 'testing_db',
        //     'user' => 'root',
        //     'pass' => '',
        //     'port' => '3306',
        //     'charset' => 'utf8',
        // ]
    ],
    'version_order' => 'creation'
];
