<?php

require_once 'ProyectoDB.php';

class Tarea {

  //Constructor  
  function __construct($codTar, $desTar, $estadoTar, $horPreHor, $horReaHor, $ordTar, $codReq, $codUsu) {
    $this->codTar = $codTar;
    $this->desTar = $desTar;
    $this->estadoTar = $estadoTar;
    $this->horPreTar = $horPreHor;
    $this->horReaTar = $horReaHor;
    $this->ordTar = $ordTar;
    $this->codReq = $codReq;
    $this->codUsu = $codUsu;
  }
  
  //Atributos de instancia
  private $codTar;
  private $desTar;
  private $estadoTar;
  private $horPreTar;
  private $horReaTar;
  private $ordTar;
  private $codReq;
  private $codUsu;

  //Métodos de instancia
  public function insert() {
    $conexion = ProyectoDB::connectDB();
    $insercion = "INSERT INTO tarea (codTar, desTar, estadoTar, horPreTar, "
            . "horReaTar,ordTar, codReq, codUsu) VALUES (NULL, '$this->desTar', "
            . "'$this->estadoTar', '$this->horPreTar', '0' , '$this->ordTar', '$this->codReq', '$this->codUsu')";
    $conexion->exec($insercion);    
  }

  public function delete() {
    $conexion = ProyectoDB::connectDB();
    $borrado = "DELETE FROM tarea WHERE codTar=\"".$this->codTar."\"";
    $conexion->exec($borrado);
  }
  
  public function update() {
    $conexion = ProyectoDB::connectDB();
    $update = "UPDATE tarea SET codTar ='$this->codTar'"
        . ", desTar ='$this->desTar', "
        . "estadoTar ='$this->estadoTar'"
        . ", horPreTar ='$this->horPreTar'"
        . ", horReaTar ='$this->horReaTar'"
        . ", ordTar ='$this->ordTar'"
        . ", codReq ='$this->codReq'"
        . ", codUsu ='$this->codUsu'"
        . " WHERE codTar=\"".$this->codTar."\"";
    $conexion->exec($update);
  }
 
  public static function getTareasByCodReq($codReq) {
    $conexion = ProyectoDB::connectDB();
    $seleccion = "SELECT codTar,desTar,estadoTar, horPreTar, horReaTar, ordTar, codReq, codUsu FROM tarea WHERE codReq=\"".$codReq."\"";
    $consulta = $conexion->query($seleccion);
    $tareas = [];
        while ($registro = $consulta->fetchObject()) {
            $tareas[] = new Tarea($registro->codTar, $registro->desTar, $registro->estadoTar, 
                $registro->horPreTar, $registro->horReaTar, $registro->ordTar, $registro->codReq, $registro->codUsu);
        }
        return $tareas;   
  }
    
  public static function getTareasByCodPro($codPro) {
    $conexion = ProyectoDB::connectDB();
    $seleccion = "SELECT codTar,desTar,estadoTar, horPreTar, horReaTar,ordTar, t.codReq, codUsu FROM tarea t, requisito r WHERE t.codReq = r.codReq and r.codPro = '$codPro' ORDER BY codTar";
    $consulta = $conexion->query($seleccion);
    $tareas = [];
        while ($registro = $consulta->fetchObject()) {
            $tareas[] = new Tarea($registro->codTar, $registro->desTar, $registro->estadoTar, 
                $registro->horPreTar, $registro->horReaTar, $registro->ordTar, $registro->codReq,$registro->codUsu);
        }
        return $tareas;   
  }
  
   public static function getTareaById($id) {
        $conexion = ProyectoDB::connectDB();
        $seleccion = "SELECT codTar,desTar,estadoTar, horPreTar, horReaTar, ordTar,codReq, codUsu FROM tarea WHERE codTar=\"" . $id . "\"";
        $consulta = $conexion->query($seleccion);
        $registro = $consulta->fetchObject();
        $tarea = new Tarea($registro->codTar, $registro->desTar, $registro->estadoTar, 
                $registro->horPreTar, $registro->horReaTar, $registro->ordTar, $registro->codReq, $registro->codUsu);
        return $tarea;
    }
    
    public function deleteByCodReq($codReq) {
    $conexion = ProyectoDB::connectDB();
    $borrado = "DELETE FROM tarea WHERE codReq=\"".$codReq."\"";
    $conexion->exec($borrado);
  }
  public static function deleteTareasByCodPro($codPro) {
    $conexion = ProyectoDB::connectDB();
    $seleccion = "SELECT codTar,desTar,estadoTar, horPreTar, horReaTar,ordTar, t.codReq, codUsu FROM tarea t, requisito r WHERE t.codReq = r.codReq and r.codPro = '$codPro' ORDER BY codTar";
    $consulta = $conexion->query($seleccion);
        while ($registro = $consulta->fetchObject()) {
            $tarea = new Tarea($registro->codTar, $registro->desTar, $registro->estadoTar, 
                $registro->horPreTar, $registro->horReaTar, $registro->ordTar, $registro->codReq,$registro->codUsu);
            $tarea->delete();
        }  
  }
  public static function ordenUltimaTarea($codPro) {
    $conexion = ProyectoDB::connectDB();
    $seleccion = "SELECT MAX(ordTar) as maximo FROM tarea t, requisito r WHERE t.codReq = r.codReq and r.codPro = '$codPro'";
    $consulta = $conexion->query($seleccion);
    $registro = $consulta->fetchObject();
    return $registro->maximo;
  }
 
  //GETTER Y SETTER
  
  function getCodTar() {
      return $this->codTar;
  }

  function getDesTar() {
      return $this->desTar;
  }

  function getHorPreTar() {
      return $this->horPreTar;
  }

  function getHorReaTar() {
      return $this->horReaTar;
  }

  function getCodReq() {
      return $this->codReq;
  }

  function getCodUsu() {
      return $this->codUsu;
  }
  
  function getEstadoTar() {
      return $this->estadoTar;
  }

  function setEstadoTar($estadoTar) {
      $this->estadoTar = $estadoTar;
  }

  function setCodTar($codTar) {
      $this->codTar = $codTar;
  }

  function setDesTar($desTar) {
      $this->desTar = $desTar;
  }

  function setHorPreTar($horPreTar) {
      $this->horPreTar = $horPreTar;
  }

  function setHorReaTar($horReaTar) {
      $this->horReaTar = $horReaTar;
  }

  function setCodReq($codReq) {
      $this->codReq = $codReq;
  }

  function setCodUsu($codUsu) {
      $this->codUsu = $codUsu;
  }

  function getOrdTar() {
      return $this->ordTar;
  }

  function setOrdTar($ordTar) {
      $this->ordTar = $ordTar;
  }



}
