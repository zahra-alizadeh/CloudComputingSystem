<?php
include('system/config.php');
include(__DIR__ . '/system/router/Routing.php');
include('system/traits/Redirect.php');
include('system/traits/View.php');
include('application/controller/Controller.php');
//include('application/controller/home1.php');
include('system/bootstrap/boot.php');

//include ('model/CreateDB.php');
//use model\CreateDB;

//$db = new CreateDB();
//$db->run();

//$r = new \system\router\Routing();
//$r->run();
//$path = "application/controller/home1.php";
//if (file_exists($path))
//    echo "yes";

//var_dump(CURRENT_ROUTE);
//$currentRoute = explode('/', CURRENT_ROUTE);
//array_shift($currentRoute);
//var_dump($currentRoute);
//$path = (dirname(__FILE__) . "application/controller/" . $currentRoute[1] . ".php");
////$path = realpath(dirname(__FILE__) . "application/controller/" . $currentRoute[1] . ".php");
//
//if (!file_exists($path))
//{
//    echo "yessss";
////    header("location:error404.php?wrong=10");
//    exit;
//}
//require_once($path);
//sizeof($currentRoute) == 1 ? $method = "home" : $method = $currentRoute[1];
//$classPath = "application\controller\\" . $currentRoute[1];
//$class = new $classPath();
//
//// if method exit get id
//if (method_exists($class, $method)) {
//    $reflection = new ReflectionMethod($classPath, $method);
//    $paramCount = $reflection->getNumberOfParameters();
//    if ($paramCount <= count(array_slice($currentRoute, 2)))
//        call_user_func(array($class, $method), array_slice($currentRoute, 2));
//    else
//        echo "parameter error!!";
//
//} else
//    echo "method not exists!!";