<?php
session_start();
//Se carga la Clase Usuario
require_once '../Model/Usuario.php';

//Login
$user = Usuario::getUsuarioById($_SESSION['codUser']);


require_once 'Twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(__DIR__.'/../View');
$twig = new Twig_Environment($loader);

if(isset($_POST['ACTION'])){
    //ALTA
    if($_POST['ACTION'] == "ALTA"){
      $nomUsu = $_POST['nomUsu'];
      $catUsu = $_POST['catUsu'];
      $emailUsu = $_POST['emailUsu'];
      $permisoUsu = $_POST['permisoUsu'];
      $loginUsu = $_POST['loginUsu'];
      $passUsu = $_POST['passUsu'];
      $usuario = new Usuario("",$nomUsu, $emailUsu, $catUsu, $loginUsu, $passUsu, $permisoUsu);
      $usuario->insert();
    } 
    //FIN ALTA
 
    //BAJA
    if($_POST['ACTION'] == "BORRAR"){
        $codUsu = $_POST['codUsu'];
      $usuario = Usuario::getUsuarioById($codUsu);
      $usuario->delete();
    } 
    //FIN BAJA

    //MODIFICAR
    if($_POST['ACTION'] == "MODIFICAR"){
      $codUsu = $_POST['codUsu'];
      $usuario = Usuario::getUsuarioById($codUsu);

      $nomUsu = $_POST['nomUsu'];
      $catUsu = $_POST['catUsu'];
      $emailUsu = $_POST['emailUsu'];
      $permisoUsu = $_POST['permisoUsu'];
      $loginUsu = $_POST['loginUsu'];
      $passUsu = $_POST['passUsu'];
      $usuario->setCodUsu($codUsu);
      $usuario->setNomUsu($nomUsu);
      $usuario->setEmailUsu($emailUsu);
      $usuario->setCatUsu($catUsu);
      $usuario->setLoginUsu($loginUsu);
      $usuario->setPassUsu($passUsu);
      $usuario->setPermisoUsu($permisoUsu);

      $usu = $usuario->update();
    } 
    $usuarios = Usuario::getUsuarios();
    echo $twig->render('listadoUsuarios.html.twig', ['usuarios' => $usuarios]);
}
// ONLOAD
else{
    $usuarios = Usuario::getUsuarios();
    echo $twig->render('indexUsuarios.html.twig', ['user' => $user, 'usuarios' => $usuarios]);
}

