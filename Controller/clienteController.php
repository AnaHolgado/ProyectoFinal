<?php
session_start();

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
      $nomempCli = $_POST['nomempCli'];
      $tlfCli = $_POST['tlfCli'];
      $emailCli =  $_POST['emailCli'];
      $nomconCli = $_POST['nomconCli'];
      $cliente = new Cliente("",$nomempCli, $tlfCli , $emailCli, $nomconCli);
      
      $cliente->insert();
    } 
//FIN ALTA
 
//BAJA
    if($_POST['ACTION'] == "BORRAR"){
      $codCli = $_POST["codCli"];
      $cliente = Cliente::getClienteById($codCli);
      $cliente->delete();
    } 
//FIN BAJA

//MODIFICAR
    if($_POST['ACTION'] == "MODIFICAR"){
      $codCli = $_POST["codCli"];
      $cliente = Cliente::getClienteById($codCli);
      $nomempCli = $_POST['nomempCli'];
      $tlfCli = $_POST['tlfCli'];
      $emailCli = $_POST['emailCli'];
      $nomconCli = $_POST['nomconCli'];
      $cliente->setCodCli($codCli);
      $cliente->setNomempCli($nomempCli);
      $cliente->setEmailCli($emailCli);
      $cliente->setTlfCli($tlfCli);
      $cliente->setNomconCli($nomconCli);

      $cliente->update();
    } 
//FIN MODIFICAR
    $clientes = Cliente::getClientes();
    echo $twig->render('listadoClientes.html.twig', ['clientes' => $clientes]);
}
//ONLOAD
else {
    $clientes = Cliente::getClientes();
    echo $twig->render('indexClientes.html.twig', ['user' => $user, 'clientes' => $clientes]);
}