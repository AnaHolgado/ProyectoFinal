<?php
session_start();
require_once '../Model/Requisito.php';
require_once '../Model/Tarea.php';
require_once '../Model/Usuario.php';
require_once '../Model/Cliente.php';
require_once '../Model/Proyecto.php';

//LOGIN
$user = Usuario::getUsuarioById($_SESSION['codUser']);

require_once 'Twig/lib/Twig/Autoloader.php';

//MODIFICAR ESTADO TAREA
if(isset($_POST['ACTION'] )){
    if($_POST['ACTION'] == "MODIFICARESTADOTAREA"){
        $codTar = $_POST['codTar'];
        $estadoTar = $_POST['estadoTar'];
        $tarea = Tarea::getTareaById($codTar);
        $tarea->setEstadoTar($estadoTar);
        $tarea->update();
    } 
    //MODIFICAR ESTADO A COMPLETADO TAREA
    else if($_POST['ACTION'] == "MODIFICARESTADOCOMPLETADOTAREA"){
        $codTar = $_POST['codTar'];
        $estadoTar = $_POST['estadoTar'];
        $horReaTar = $_POST['horReaTar'];
        $tarea = Tarea::getTareaById($codTar);
        $tarea->setHorReaTar($horReaTar);
        $tarea->setEstadoTar($estadoTar);
        $tarea->update();
        $requisito = Requisito::getRequisitoByCodTar($codTar);
        $requisito->sumaHorasRealizadasTareas();   
        $proyecto = Proyecto::getProyectoById($_SESSION['codPro']);
        $proyecto->sumaHorasRealizadasReq();
    } 
}
//ONLOAD
else{
    if(isset($_SESSION['codPro'])){
        $codPro = $_SESSION['codPro'];
    }else {
        $codPro = $_POST['codProPiz'];
        $_SESSION['codPro'] = $codPro;
    }
    $requisitos = Requisito::getRequisitosByCodPro($codPro);
    $tareas = Tarea::getTareasByCodPro($codPro);
    $programadores = Usuario::getUsuarios();
    $clientes = Cliente::getClientes();

    Twig_Autoloader::register();
    $loader = new Twig_Loader_Filesystem(__DIR__.'/../View');
    $twig = new Twig_Environment($loader);
    echo $twig->render('pizarra.html.twig', ['user' => $user,'requisitos' => $requisitos, 'codPro' => $codPro, 'tareas' => $tareas, 'programadores' => $programadores, 'clientes' => $clientes]);
}
