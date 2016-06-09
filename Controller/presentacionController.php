<?php
session_start();
require_once '../Model/Usuario.php';
require_once '../Model/Proyecto.php';


//Logueo
$user = Usuario::getUsuarioById($_SESSION['codUser']);
require_once 'Twig/lib/Twig/Autoloader.php';
     
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(__DIR__.'/../View');
$twig = new Twig_Environment($loader);
//ADMIN
if($user->getPermisoUsu() == "ADMIN"){
    if(isset($_POST['ACTION'])){
        if($_POST['ACTION'] == "CAMBIARPASS"){
            $passUsu = $_POST['passUsu'];
            $passNueva = $_POST['passNueva'];
            $passNuevaR = $_POST['passNuevaR'];

            if($passUsu == $user->getPassUsu() && $passNueva === $passNuevaR){
                $user->setPassUsu($passNueva);
                $user = $user->update();
                echo "true";
            }else {
                echo "false";
            }
        }
        if($_POST['ACTION'] === "FILTRO"){
            $filtro = $_POST['filtro'];
            if($filtro != "TODOS"){
                $proyectos = Proyecto::getProyectosPendientes($filtro);
                echo $twig->render('listadoPresentacion.html.twig',['proyectos' => $proyectos]);
            }
            else {
                $proyectos = Proyecto::getProyectos();
                echo $twig->render('listadoPresentacion.html.twig',['proyectos' => $proyectos]);
            }
        }
    }else {
        if(isset($_SESSION['codPro'])){
            unset($_SESSION['codPro']);
        }
        $proyectos = Proyecto::getProyectos();
        echo $twig->render('indexPresentacion.html.twig',['user' => $user, 'proyectos' => $proyectos]);
    }
}
//USUARIO NORMAL
else {
    //CAMBIAR PASS
    if(isset($_POST['ACTION'])){
            if($_POST['ACTION'] == "CAMBIARPASS"){
                $passUsu = $_POST['passUsu'];
                $passNueva = $_POST['passNueva'];
                $passNuevaR = $_POST['passNuevaR'];

                if($passUsu == $user->getPassUsu() && $passNueva === $passNuevaR){
                    $user->setPassUsu($passNueva);
                    $user = $user->update();
                    echo "true";
                }else {
                    echo "false";
                }
            }
            if($_POST['ACTION'] === "FILTRO"){
            $filtro = $_POST['filtro'];
            if($filtro != "TODOS"){
                $proyectos = Proyecto::getProyectosFasesByCodUsu($filtro, $user->getCodUsu());
                echo $twig->render('listadoPresentacion.html.twig',['proyectos' => $proyectos]);
            }
            else {
                $proyectos = Proyecto::getProyectosByCodUsu($user->getCodUsu());
                echo $twig->render('listadoPresentacion.html.twig',['proyectos' => $proyectos]);
            }
        }
    }else {
        if(isset($_SESSION['codPro'])){
            unset($_SESSION['codPro']);
        }
        $proyectos = Proyecto::getProyectosByCodUsu($user->getCodUsu());
        echo $twig->render('indexPresentacion.html.twig',['user' => $user, 'proyectos' => $proyectos]);
    }
}

