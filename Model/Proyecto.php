<?php

require_once 'ProyectoDB.php';

class Proyecto {
  //Constructor  
  function __construct($codPro, $nomPro, $fechiniPro, $fechfinPro,$horasPro,$horReaPro, $fasePro, $codCli) {
    $this->codPro = $codPro;
    $this->nomPro = $nomPro;
    $this->fechiniPro = $fechiniPro;
    $this->fechfinPro = $fechfinPro;
    $this->horasPro = $horasPro;
    $this->fasePro = $fasePro;
    $this->codCli = $codCli;
    $this->horReaPro = $horReaPro;
  }
  
  //Atributos de instancia
  private $codPro;
  private $nomPro;
  private $fechiniPro;
  private $fechfinPro;
  private $horasPro;
  private $horReaPro;
  private $fasePro;
  private $codCli;
  
  //Métodos de instancia
  public function insert() {
    $conexion = ProyectoDB::connectDB();
    $insercion = "INSERT INTO proyecto (nomPro, fechfinPro, horasPro,horReaPro, fasePro, codCli) "
        . "VALUES (\"".$this->nomPro."\", \"".$this->fechfinPro."\",\""
        .$this->horasPro."\",\"".$this->horReaPro."\",\"".$this->fasePro."\",\"".$this->codCli."\")";
    echo $insercion;
    $conexion->exec($insercion);
}
  
  public function delete() {
    $conexion = ProyectoDB::connectDB();
    $borrado = "DELETE FROM proyecto WHERE codPro=\"".$this->codPro."\"";
    $conexion->exec($borrado);
  }
  
  public function update() {
    $conexion = ProyectoDB::connectDB();
    $update = "UPDATE proyecto SET nomPro ='$this->nomPro' "
        . ", fechfinPro ='$this->fechfinPro' "
        . ", fasePro ='$this->fasePro' "
        . ", codCli ='$this->codCli'"
        . " WHERE codPro=\"".$this->codPro."\"";
    $conexion->exec($update);
    $proyecto = Proyecto::getProyectoById($this->codPro);
    return $proyecto; 
  }
  
  public static function getProyectos() {
    $conexion = ProyectoDB::connectDB();
    $seleccion = "SELECT proyecto.codPro, proyecto.nomPro, proyecto."
        . "fechiniPro, proyecto.fechfinPro, proyecto.horasPro, "
        . "proyecto.horReaPro, proyecto.fasePro, proyecto.codCli FROM proyecto "
        . " ORDER BY codPro DESC ";
    $consulta = $conexion->query($seleccion);
    $proyectos = [];
    while ($registro = $consulta->fetchObject()) {
      $proyecto = new Proyecto($registro->codPro, $registro->nomPro,  
          date_format(date_create($registro->fechiniPro), "d-m-Y"), date_format(date_create($registro->fechfinPro), "d-m-Y"), $registro->horasPro, $registro->horReaPro, 
          $registro->fasePro, $registro->codCli);
      $proyectos[] = $proyecto;
    }
    return $proyectos;   
  }
  public static function getProyectosPendientes($fase) {
    $conexion = ProyectoDB::connectDB();
    $seleccion = "SELECT proyecto.codPro, proyecto.nomPro, proyecto."
        . "fechiniPro, proyecto.fechfinPro, proyecto.horasPro, "
        . "proyecto.horReaPro, proyecto.fasePro, proyecto.codCli FROM proyecto WHERE fasePro = '$fase'"
        . " ORDER BY codPro DESC ";
    $consulta = $conexion->query($seleccion);
    $proyectos = [];
    while ($registro = $consulta->fetchObject()) {
      $proyecto = new Proyecto($registro->codPro, $registro->nomPro,  
          date_format(date_create($registro->fechiniPro), "d-m-Y"), date_format(date_create($registro->fechfinPro), "d-m-Y"), $registro->horasPro, $registro->horReaPro, 
          $registro->fasePro, $registro->codCli);
      $proyectos[] = $proyecto;
    }
    return $proyectos;   
  }
 
  public static function getProyectoById($id) {
    $conexion = ProyectoDB::connectDB();
    $seleccion = "SELECT codPro, nomPro, fechiniPro, fechfinPro, horasPro, horReaPro, fasePro, "
        . "codCli FROM proyecto WHERE codPro=\"".$id."\"";
    $consulta = $conexion->query($seleccion);
    $registro = $consulta->fetchObject();
    $proyecto = new Proyecto($registro->codPro, $registro->nomPro, 
        $registro->fechiniPro, $registro->fechfinPro, $registro->horasPro, $registro->fasePro, $registro->horReaPro, $registro->codCli);
    return $proyecto;    
  }
  public static function getProyectosByCodUsu($codUsu) {
    $conexion = ProyectoDB::connectDB();
    $seleccion = "SELECT proyecto.codPro, proyecto.nomPro, proyecto."
        . "fechiniPro, proyecto.fechfinPro, proyecto.horasPro, "
        . "proyecto.horReaPro, proyecto.fasePro, proyecto.codCli "
        . "FROM proyecto "
        . "WHERE codPro =ANY (SELECT codPro from requisito where codReq =ANY "
        . "(SELECT codReq from tarea where codUsu = '$codUsu' ) )"
        . " ORDER BY codPro DESC ";
    $consulta = $conexion->query($seleccion);
    $proyectos = [];
    while ($registro = $consulta->fetchObject()) {
      $proyecto = new Proyecto($registro->codPro, $registro->nomPro,  
          date_format(date_create($registro->fechiniPro), "d-m-Y"), date_format(date_create($registro->fechfinPro), "d-m-Y"), $registro->horasPro, $registro->horReaPro, 
          $registro->fasePro, $registro->codCli);
      $proyectos[] = $proyecto;
    }
    return $proyectos;   
  }
  public static function getProyectosFasesByCodUsu($fase, $codUsu) {
    $conexion = ProyectoDB::connectDB();
    $seleccion = "SELECT proyecto.codPro, proyecto.nomPro, proyecto."
        . "fechiniPro, proyecto.fechfinPro, proyecto.horasPro, "
        . "proyecto.horReaPro, proyecto.fasePro, proyecto.codCli "
        . "FROM proyecto "
        . "WHERE fasePro = '$fase' AND codPro =ANY (SELECT codPro from requisito where codReq =ANY "
        . "(SELECT codReq from tarea where codUsu = '$codUsu' ) )"
        . " ORDER BY codPro DESC ";
    $consulta = $conexion->query($seleccion);
    $proyectos = [];
    while ($registro = $consulta->fetchObject()) {
      $proyecto = new Proyecto($registro->codPro, $registro->nomPro,  
          date_format(date_create($registro->fechiniPro), "d-m-Y"), date_format(date_create($registro->fechfinPro), "d-m-Y"), $registro->horasPro, $registro->horReaPro, 
          $registro->fasePro, $registro->codCli);
      $proyectos[] = $proyecto;
    }
    return $proyectos;   
  }

  public function sumaHorasPrevistasReq() {
    $conexion = ProyectoDB::connectDB();
    $update = "UPDATE proyecto SET "
                . " horasPro =(SELECT SUM(horaPreReq) FROM requisito WHERE codPro='" . $this->codPro . "')"
                . " WHERE codPro=\"" . $this->codPro . "\"";
    $conexion->exec($update);
  }

  public function sumaHorasRealizadasReq() {
    $conexion = ProyectoDB::connectDB();
    $update = "UPDATE proyecto SET "
                . " horReaPro =(SELECT SUM(horaReq) FROM requisito WHERE codPro='" . $this->codPro . "')"
                . " WHERE codPro=\"" . $this->codPro . "\"";
    $conexion->exec($update);
  }
 
  //Getter y setter de instancia
  function getCodPro() {
    return $this->codPro;
  }

  function getNomPro() {
    return $this->nomPro;
  }

  function getFechiniPro() {
    return $this->fechiniPro;
  }

  function getFechfinPro() {
    return $this->fechfinPro;
  }

  function getHorasPro() {
    return $this->horasPro;
  }

  function getFasePro() {
    return $this->fasePro;
  }

  function getCodCli() {
    return $this->codCli;
  }

  function setCodPro($codPro) {
    $this->codPro = $codPro;
  }

  function setNomPro($nomPro) {
    $this->nomPro = $nomPro;
  }

  function setFechiniPro($fechiniPro) {
    $this->fechiniPro = $fechiniPro;
  }

  function setFechfinPro($fechfinPro) {
    $this->fechfinPro = $fechfinPro;
  }

  function setHorasPro($horasPro) {
    $this->horasPro = $horasPro;
  }

  function setFasePro($fasePro) {
    $this->fasePro = $fasePro;
  }

  function setCodCli($codCli) {
    $this->codCli = $codCli;
  }

  function getHorReaPro() {
      return $this->horReaPro;
  }

  function setHorReaPro($horReaPro) {
      $this->horReaPro = $horReaPro;
  }



}
