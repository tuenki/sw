<?php
require_once 'config.php';
$url = $_GET["url"] ?? "Index/index";
$url = explode('/',$url);

$controller="";
$method ="";

//Caputara de controlador y metodo de la url
if(isset($url[0]))
{
    $controller=$url[0];
}
if(isset($url[1]))
{
    if($url[1] != '')
    {
        $method=$url[1];
    }   
}

//Carga las librerias existentes
spl_autoload_register(function($class)
{
    if(file_exists(LIBRERY.$class.".php"))
    {
        require_once LIBRERY.$class.".php";
    }
});
//$objH = new Hola();
//echo $controller." ".$method;

//Carga de los controladores y metodos
require_once CONTROLLER."Errors.php";
$error = new Errors();
$controllerPath = CONTROLLER.$controller.".php";
if(file_exists($controllerPath))
{
    require_once $controllerPath;
    $controller = new $controller();
    if(isset($method))
    {
        if(method_exists($controller,$method))
        {
            $controller->{$method}();
        }
        else
        {
            $error->error();
        }
    }
}
else
{
    $error->error();
}
?>
