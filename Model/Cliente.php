<?php

require_once 'ProyectoDB.php';

class Cliente {

  //Constructor  
  function __construct($codCli, $nomempCli, $tlfCli, $emailCli, $nomconCli) {
    $this->codCli = $codCli;
    $this->nomempCli = $nomempCli;
    $this->emailCli = $emailCli;
    $this->tlfCli = $tlfCli;
    $this->nomconCli = $nomconCli;
  }
  
  //Atributos de instancia
  private $codCli;
  private $nomempCli;
  private $emailCli;
  private $tlfCli;
  private $nomconCli;
  
  //Métodos de instancia
  public function insert() {
      
    $conexion = ProyectoDB::connectDB();
    $insercion = "INSERT INTO cliente (nomempCli,tlfCli,emailCli,nomconCli) VALUES (\"".$this->nomempCli."\",\"".$this->tlfCli."\", \"".$this->emailCli."\",\"".$this->nomconCli."\");";
    $conexion->exec($insercion);
    $seleccion = " SELECT MAX(codCli) AS idCliente FROM cliente ";
    $consulta = $conexion->query($seleccion);
    $registro = $consulta->fetchObject();
    return $registro->idCliente;  
    
  }

  public function delete() {
    $conexion = ProyectoDB::connectDB();
    $borrado = "DELETE FROM cliente WHERE codCli=\"".$this->codCli."\"";
    echo $borrado;
    $conexion->exec($borrado);
  }
  
  public function update() {
    $conexion = ProyectoDB::connectDB();
    $update = "UPDATE cliente SET nomempCli ='$this->nomempCli'"
        . ", emailCli ='$this->emailCli', tlfCli ='$this->tlfCli'"
        . ", nomconCli ='$this->nomconCli'"
        . " WHERE codCli=\"".$this->codCli."\"";
    $conexion->exec($update);
  }
  
  public static function getClientes() {
    $conexion = ProyectoDB::connectDB();
    $seleccion = "SELECT codCli, nomempCli, emailCli, tlfCli, nomconCli FROM cliente";
    $consulta = $conexion->query($seleccion);
    $usuarios = [];
    while ($registro = $consulta->fetchObject()) {
      $usuarios[] = new Cliente($registro->codCli, $registro->nomempCli,  
          $registro->tlfCli, $registro->emailCli, $registro->nomconCli);
    }
    return $usuarios;   
  }
 
  public static function getClienteById($id) {
    $conexion = ProyectoDB::connectDB();
    $seleccion = "SELECT codCli,nomempCli,emailCli,tlfCli,nomconCli FROM cliente WHERE codCli=\"".$id."\"";
    $consulta = $conexion->query($seleccion);
    $registro = $consulta->fetchObject();
    $cliente = new Cliente($registro->codCli, $registro->nomempCli, $registro->emailCli, $registro->tlfCli, $registro->nomconCli);
    return $cliente;    
  }
    
  public static function getCodClibyNomempCli($nomempCli){
    $conexion = ProyectoDB::connectDB();
    $seleccion = "SELECT codCli FROM cliente WHERE  nomempCli=\"".$nomempCli."\"";
    $consulta = $conexion->query($seleccion);
    $registro= $consulta->fetchObject();
    $codCli = $registro->codCli; 
    return $codCli;
  }
 
  //Getter y setter de instancia
  function getCodCli() {
    return $this->codCli;
  }

  function getNomempCli() {
    return $this->nomempCli;
  }

  function getEmailCli() {
    return $this->emailCli;
  }

  function getTlfCli() {
    return $this->tlfCli;
  }

  function getNomconCli() {
    return $this->nomconCli;
  }

  function setCodCli($codCli) {
    $this->codCli = $codCli;
  }

  function setNomempCli($nomempCli) {
    $this->nomempCli = $nomempCli;
  }

  function setEmailCli($emailCli) {
    $this->emailCli = $emailCli;
  }

  function setTlfCli($tlfCli) {
    $this->tlfCli = $tlfCli;
  }

  function setNomconCli($nomconCli) {
    $this->nomconCli = $nomconCli;
  }


}
