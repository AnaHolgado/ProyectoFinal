<?php
session_start();
require_once '../Model/Proyecto.php';
require_once '../Model/Requisito.php';
require_once '../Model/Tarea.php';
require_once '../Model/Usuario.php';

//LOGIN
$user = Usuario::getUsuarioById($_SESSION['codUser']);

require_once 'Twig/lib/Twig/Autoloader.php';

Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(__DIR__.'/../View');
$twig = new Twig_Environment($loader);

if(isset($_POST['ACTION'])){
    //ALTA
    if($_POST['ACTION'] == "ALTA"){
      $desReqAlta = $_POST['desReqAlta'];
      $estReqAlta = $_POST['estReqAlta'];
      $codPro = $_POST['codPro'];
      
      $requisito = new Requisito(NULL,$desReqAlta,$estReqAlta,"0","0", $codPro);
      $requisito->insert();
    } 
//FIN ALTA
 
//BORRAR REQUISITO CON SUS TAREAS
    if($_POST['ACTION'] == "BORRAR"){
      $codReq = $_POST['codReq'];
      $codPro = $_POST['codPro'];
      $tareas = Tarea::getTareasByCodReq($codReq);
      foreach ($tareas as $tarea){
          $tarea->delete();
      }
      //$tarea = Tarea::deleteByCodReq($codReq);
      $requisito = Requisito::getRequisitoById($codReq);
      $requisito->delete();
    } 
//FIN BAJA

//MODIFICAR
    if($_POST['ACTION'] == "MODIFICAR"){
      //Recoger varibales
      $codPro = $_POST['codPro'];
      $codReq = $_POST['codReq'];
      $requisito = Requisito::getRequisitoById($codReq);
      $desReq = $_POST['desReq'];
      $estadoReq = $_POST['estadoReq'];
      
      $requisito->setDesReq($desReq);
      $requisito->setEstadoReq($estadoReq);
      
      $requisito->update();
 
    } 
//FIN MODIFICAR

//ALTA TAREA
    if($_POST['ACTION'] == "ALTATAREA"){
      $codReq = $_POST['codReq'];
      $desTar = $_POST['desTar'];
      $estadoTar = $_POST['estadoTar'];
      $horPreTar = $_POST['horPreTar'];
      $ordTar = $_POST['ordTar'];
      $codUsu = $_POST['codUsu'];
      $codPro = $_POST['codPro'];
      $tarea = new Tarea(NULL,$desTar,$estadoTar,$horPreTar,"0", $ordTar, $codReq,$codUsu);
      $tarea->insert();
      
      $requisito = Requisito::getRequisitoById($codReq);
      $requisito->sumaHorasPrevistasTareas();
      
      $proyecto = Proyecto::getProyectoById($codPro);
      $proyecto->sumaHorasPrevistasReq();
    } 
 
//MODIFICAR TAREA
    if($_POST['ACTION'] == "MODIFICARTAREA"){
      $codTar = $_POST['codTar'];
      $codReq = $_POST['codReq'];
      $desTar = $_POST['desTar'];
      $estadoTar = $_POST['estadoTar'];
      $horPreTar = $_POST['horPreTar'];
      $horReaTar = $_POST['horReaTar'];
      $ordTar = $_POST['ordTar'];
      $codUsu = $_POST['codUsu'];
      $codPro = $_POST['codPro'];
      
      $tarea = Tarea::getTareaById($codTar);
      
      $tarea->setDesTar($desTar);
      $tarea->setEstadoTar($estadoTar);
      $tarea->setEstadoTar($estadoTar);
      $tarea->setHorPreTar($horPreTar);
      $tarea->setHorReaTar($horReaTar);
      $tarea->setOrdTar($ordTar);
      $tarea->setCodUsu($codUsu);
      
      $tarea->update();
      
      $requisito = Requisito::getRequisitoById($codReq);
      $requisito->sumaHorasPrevistasTareas();
      $requisito->sumaHorasRealizadasTareas();
      
      $proyecto = Proyecto::getProyectoById($codPro);
      $proyecto->sumaHorasPrevistasReq();
      $proyecto->sumaHorasRealizadasReq();
    } 
//FIN MODIFICAR
  
//BAJA TAREA
    if($_POST['ACTION'] == "BORRARTAREA"){
      $codTar = $_POST['codTar'];
      $codReq = $_POST['codReq'];
      $codPro = $_POST['codPro'];
      $tarea = Tarea::getTareaById($codTar);
      $tarea->delete();
      
      $requisito = Requisito::getRequisitoById($codReq);
      $requisito->sumaHorasPrevistasTareas();
      $requisito->sumaHorasRealizadasTareas();
      
      $proyecto = Proyecto::getProyectoById($codPro);
      $proyecto->sumaHorasPrevistasReq();
      $proyecto->sumaHorasRealizadasReq();
      
    } 
//FIN BAJA TAREA

    $ordUltTar = Tarea::ordenUltimaTarea($codPro);
    $requisitos = Requisito::getRequisitosByCodPro($codPro);
    $tareas = Tarea::getTareasByCodPro($codPro);
    $programadores = Usuario::getUsuarios();
    echo $twig->render('listadoRequisitos.html.twig',['requisitos' => $requisitos,  'tareas' => $tareas, 'programadores' => $programadores, "ordUltTar" => $ordUltTar]);
//FIN ALTA
}else{
    if(isset($_SESSION['codPro'])){
        $codPro = $_SESSION['codPro'];
    }else {
        $codPro = $_POST['codProReq'];
        $_SESSION['codPro'] = $codPro;
    }
    
    $ordUltTar = Tarea::ordenUltimaTarea($codPro);
    $requisitos = Requisito::getRequisitosByCodPro($codPro);
    $tareas = Tarea::getTareasByCodPro($codPro);
    $programadores = Usuario::getUsuarios();

    
    echo $twig->render('indexRequisitos.html.twig', ['user' => $user,'requisitos' => $requisitos, 'codPro' => $codPro, 'tareas' => $tareas, 'programadores' => $programadores, "ordUltTar" => $ordUltTar]);
}