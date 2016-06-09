<?php
session_start();
//Se carga la Clase Usuario
require_once '../Model/Usuario.php';


require_once 'Twig/lib/Twig/Autoloader.php';
    
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(__DIR__.'/../View');
$twig = new Twig_Environment($loader);
unset($_SESSION['codUser']);
if(isset($_POST['ACTION'])){
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $usuario = Usuario::getUsuarioByLogin($user);
    if($user == $usuario->getLoginUsu() && $pass === $usuario->getPassUsu()){
        $_SESSION['codUser'] = $usuario->getCodUsu();
        echo "true";
    }else {
        echo "false";
    }
}else {
    echo $twig->render('index.html.twig');
}
/*
//Se carga la Clase Usuario
require_once '../Model/Usuario.php';

//Se busca en la base de datos los datos de todos los usuarios
$data['usuarios'] = Usuario::getUsuarios();

// Carga la vista de listado
include '../View/listadoUsuarios.php';

*/