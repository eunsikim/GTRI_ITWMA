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

require_once($_SERVER['DOCUMENT_ROOT']."/mysql/config.php");

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
// echo '<pre>',var_dump($ModuleColumn),'</pre>';

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

// Query all the user's module in userModules table
$_SERVER['PINNED_MODULES'] = array();

$usermodule = array();
$sql3 = "SELECT module_name from modules JOIN usermodules on modules.id = usermodules.module_id 
JOIN users on users.id = usermodules.user_id";
$result = mysqli_query($conn, $sql3);
//echo '<pre>',var_dump($result),'</pre>';
while($mod = mysqli_fetch_array($result)){
    array_push($usermodule, $mod);
}
$unpinnedmodules = array_intersect($ModuleColumn,$result);
foreach ($unpinnedmodules as $value) 
{
  if (in_array($value, $ModuleColumn))
  {
    
  }
}

mysqli_close($conn);

//Load Twig Templating Engine
$_SESSION['LOADER'] = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT']);
$_SESSION['TWIG'] = new \Twig\Environment($_SESSION['LOADER']);

//Load routers
require_once($_SERVER['DOCUMENT_ROOT'].'/router/routes.php');
