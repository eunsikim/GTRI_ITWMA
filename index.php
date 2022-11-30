<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
use Ramsey\Uuid\Uuid;

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

// echo '<pre>',var_dump($_SERVER['MODULE_PATHS']),'</pre>';
//Load .env file
$dotenv = Dotenv\Dotenv::createMutable('./');
$dotenv->load();

include($_SERVER['DOCUMENT_ROOT']."/mysql/config.php");

//Adding module names to array
$moduleID = Uuid::uuid4();
$modulenames = array();
$names = "SELECT module_name FROM `modules`";
$res = mysqli_query($conn, $names);

while($name = mysqli_fetch_array($res)){
    array_push($modulenames, $name['module_name']);
}

$ModuleColumn = array();
$length = count($_SERVER['MODULE_PATHS']);
for ($i = 0; $i < $length; $i++){
    array_push($ModuleColumn, $_SERVER['MODULE_PATHS'][$i][1]);
}

// echo '<pre>',var_dump($modulenames),'</pre>';


$mismatchedmodules = array_diff($ModuleColumn,$modulenames);
// echo '<pre>',var_dump($mismatchedmodules),'</pre>';

foreach ($mismatchedmodules as $value) 
{
  if (in_array($value, $ModuleColumn))
  {
    $sql = "INSERT INTO modules(id, module_name) VALUES ('".$moduleID."', '".$value."');";
    $res2 = mysqli_query($conn, $sql);   
  }
}

foreach($modulenames as $value){
  if(!in_array($value, $ModuleColumn))
    {
      $deleterow = "DELETE FROM modules WHERE module_name = '".$value."'";
      $res3 = mysqli_query($conn, $deleterow);
    }  
}

$_SERVER['moduleColumn'] = $ModuleColumn;

$_SERVER['PINNED_MODULES'] = array();

//echo '<pre>',var_dump($_SERVER['moduleColumn']),'</pre>';

// Query all the user's module in userModules table
// 

mysqli_close($conn);

//Load Twig Templating Engine
$_SESSION['LOADER'] = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT']);
$_SESSION['TWIG'] = new \Twig\Environment($_SESSION['LOADER']);

//Load routers
require_once($_SERVER['DOCUMENT_ROOT'].'/router/routes.php');
