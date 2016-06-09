<?php
session_start();
require_once '../Model/Proyecto.php';
require_once '../Model/Requisito.php';
require_once '../Model/Tarea.php';
require_once '../Model/Cliente.php';

//LOGIN
require_once '../Model/Usuario.php';
$user = Usuario::getUsuarioById($_SESSION['codUser']);

require_once 'Twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(__DIR__.'/../View');
$twig = new Twig_Environment($loader);

if(isset($_POST['ACTION'])){
//ALTA
    if($_POST['ACTION'] == "ALTA"){
      $nomPro = $_POST['nomPro'];
      $fech = $_POST['fechfinPro'];
      $fechfinPro= date("Y-m-d", strtotime("$fech"));
      $fasePro = $_POST['fasePro'];
      $codCli = $_POST['codCli'];
      $proyecto = new Proyecto("",$nomPro,"", $fechfinPro, "0","0", $fasePro, $codCli);
      $proyecto->insert();
    } 
//FIN ALTA
 
//BAJA
    if($_POST['ACTION'] == "BORRAR"){
      $codPro = $_POST['codPro'];
      Requisito::deleteRequisitosByCodPro($codPro);
      Tarea::deleteTareasByCodPro($codPro);
      
      $proyecto = Proyecto::getProyectoById($codPro);
      $proyecto->delete();
    } 
//FIN BAJA

//MODIFICAR
    if($_POST['ACTION'] == "MODIFICAR"){
      //Recoger varibales
      $codPro = $_POST['codPro'];
      $proyecto = Proyecto::getProyectoById($codPro);
      $nomPro = $_POST['nomPro'];
      $fechfinPro = $_POST['fechfinPro'];
      //$horasPro = $_POST['horasPro'];
      $fasePro = $_POST['fasePro'];
      $codCli = $_POST['codCli'];
      
      /*Pasar el nomempCli a codCli*/
      //$codCli = Cliente::getCodClibyNomempCli($nomempCli);
      /*Pasar la fecha a un formato que entieda la BBDD*/
      $fechfinPro = date("Y-m-d", strtotime("$fechfinPro"));
      //Pasar los datos al modelo
      $proyecto->setCodPro($codPro);
      $proyecto->setNomPro($nomPro);
      $proyecto->setFechfinPro($fechfinPro);
      //$proyecto->setHorasPro($horasPro);
      $proyecto->setFasePro($fasePro);
      $proyecto->setCodCli($codCli);
      
      $proyecto = $proyecto->update();
   } 
    $proyectos = Proyecto::getProyectos();
    $clientes = Cliente::getClientes();

    echo $twig->render('listadoProyectos.html.twig', ['proyectos' => $proyectos ,'clientes' => $clientes]);
  
}
//ONLOAD
else {
    $proyectos = Proyecto::getProyectos();
    $clientes = Cliente::getClientes();
    if(isset($_SESSION['codPro'])){
        unset($_SESSION['codPro']);
    }
    echo $twig->render('indexProyectos.html.twig', ['user' => $user, 'proyectos' => $proyectos ,'clientes' => $clientes]);
  
}

